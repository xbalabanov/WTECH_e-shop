<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $searchQuery = trim((string) $request->query('q', ''));
        $selectedLanguages = array_values(array_filter((array) $request->query('languages', [])));
        $selectedAuthorIds = array_map('intval', array_filter((array) $request->query('authors', [])));
        $selectedCategoryIds = array_map('intval', array_filter((array) $request->query('categories', [])));
        $selectedGenres = array_values(array_filter((array) $request->query('genres', [])));
        $sort = (string) $request->query('sort', 'newest');

        $priceFloor = (int) floor((float) (Book::min('price') ?? 0));
        $priceCeil = (int) ceil((float) (Book::max('price') ?? 100));
        $priceCeil = max($priceCeil, $priceFloor + 1);

        $selectedMinPrice = (float) $request->query('min_price', $priceFloor);
        $selectedMaxPrice = (float) $request->query('max_price', $priceCeil);

        $selectedMinPrice = max($priceFloor, min($selectedMinPrice, $priceCeil));
        $selectedMaxPrice = max($priceFloor, min($selectedMaxPrice, $priceCeil));

        if ($selectedMinPrice > $selectedMaxPrice) {
            [$selectedMinPrice, $selectedMaxPrice] = [$selectedMaxPrice, $selectedMinPrice];
        }

        $category = $categorySlug
            ? Category::where('slug', $categorySlug)->first()
            : null;

        $languages = Book::query()
            ->whereNotNull('language')
            ->where('language', '!=', '')
            ->select('language')
            ->distinct()
            ->orderBy('language')
            ->pluck('language');

        $authors = Author::query()
            ->orderBy('full_name')
            ->get(['id', 'full_name']);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $genres = Book::query()
            ->whereNotNull('genre')
            ->where('genre', '!=', '')
            ->select('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        $books = Book::query()
            ->with(['authors', 'categories', 'publisher'])
            ->when($searchQuery !== '', function ($query) use ($searchQuery) {
                $query->where(function ($inner) use ($searchQuery) {
                    $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $searchQuery) . '%';

                    $inner
                        ->where('title', 'ILIKE', $like)
                        ->orWhere('description', 'ILIKE', $like)
                        ->orWhere('isbn', 'ILIKE', $like)
                        ->orWhere('genre', 'ILIKE', $like)
                        ->orWhere('language', 'ILIKE', $like)
                        ->orWhereHas('authors', fn ($q) => $q->where('full_name', 'ILIKE', $like))
                        ->orWhereHas('publisher', fn ($q) => $q->where('name', 'ILIKE', $like));
                });
            })
            ->when(
                $category,
                fn ($query) => $query->whereHas('categories', fn ($q) => $q->where('slug', $categorySlug))
            )
            ->when(
                !empty($selectedLanguages),
                fn ($query) => $query->whereIn('language', $selectedLanguages)
            )
            ->when(
                !empty($selectedGenres),
                fn ($query) => $query->whereIn('genre', $selectedGenres)
            )
            ->when(
                !empty($selectedAuthorIds),
                fn ($query) => $query->whereHas('authors', fn ($q) => $q->whereIn('authors.id', $selectedAuthorIds))
            )
            ->when(
                !empty($selectedCategoryIds),
                fn ($query) => $query->whereHas('categories', fn ($q) => $q->whereIn('categories.id', $selectedCategoryIds))
            )
            ->whereBetween('price', [$selectedMinPrice, $selectedMaxPrice])
            ->when($sort === 'oldest', fn ($query) => $query->oldest())
            ->when($sort === 'price-low-high', fn ($query) => $query->orderBy('price'))
            ->when($sort === 'price-high-low', fn ($query) => $query->orderByDesc('price'))
            ->when(!in_array($sort, ['oldest', 'price-low-high', 'price-high-low'], true), fn ($query) => $query->latest())
            ->paginate(8)
            ->withQueryString();

        $cartQuantities = collect((array) $request->session()->get('cart', []))
            ->mapWithKeys(fn ($quantity, $bookId) => [(int) $bookId => max(0, (int) $quantity)])
            ->all();

        return view('category-template', [
            'books' => $books,
            'categoryTitle' => $category?->name ?? 'All Books',
            'categorySubtitle' => $searchQuery !== ''
                ? 'Results for "' . $searchQuery . '"'
                : 'Browse books from the database.',
            'languages' => $languages,
            'authors' => $authors,
            'categories' => $categories,
            'genres' => $genres,
            'selectedLanguages' => $selectedLanguages,
            'selectedAuthorIds' => $selectedAuthorIds,
            'selectedCategoryIds' => $selectedCategoryIds,
            'selectedGenres' => $selectedGenres,
            'sort' => $sort,
            'priceFloor' => $priceFloor,
            'priceCeil' => $priceCeil,
            'selectedMinPrice' => $selectedMinPrice,
            'selectedMaxPrice' => $selectedMaxPrice,
            'cartQuantities' => $cartQuantities,
            'searchQuery' => $searchQuery,
        ]);
    }
}