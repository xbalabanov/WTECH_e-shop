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
        $searchName = trim((string) $request->query('name', ''));
        $searchAuthor = trim((string) $request->query('author', ''));
        $searchIsbn = trim((string) $request->query('isbn', ''));
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
            ->when($searchQuery !== '' || $searchName !== '' || $searchAuthor !== '' || $searchIsbn !== '', function ($query) use ($searchQuery, $searchName, $searchAuthor, $searchIsbn) {
                $query->where(function ($inner) use ($searchQuery, $searchName, $searchAuthor, $searchIsbn) {
                    $appliedCondition = false;

                    $addTextCondition = function (string $column, string $value) use (&$inner, &$appliedCondition) {
                        $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $value) . '%';

                        if ($appliedCondition) {
                            $inner->orWhere($column, 'ILIKE', $like);
                        } else {
                            $inner->where($column, 'ILIKE', $like);
                            $appliedCondition = true;
                        }
                    };

                    $addAuthorCondition = function (string $value) use (&$inner, &$appliedCondition) {
                        $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $value) . '%';

                        if ($appliedCondition) {
                            $inner->orWhereHas('authors', fn ($q) => $q->where('full_name', 'ILIKE', $like));
                        } else {
                            $inner->whereHas('authors', fn ($q) => $q->where('full_name', 'ILIKE', $like));
                            $appliedCondition = true;
                        }
                    };

                    if ($searchName !== '') {
                        $addTextCondition('title', $searchName);
                    } elseif ($searchQuery !== '') {
                        $addTextCondition('title', $searchQuery);
                    }

                    if ($searchIsbn !== '') {
                        $addTextCondition('isbn', $searchIsbn);
                    }

                    if ($searchAuthor !== '') {
                        $addAuthorCondition($searchAuthor);
                    }
                });
            })
            ->when(
                $category,
                fn ($query) => $query->whereHas('categories', fn ($q) => $q->where('slug', $categorySlug))
            )
            ->when(
                $categorySlug === 'sale',
                fn ($query) => $query->where('discount', '>', 0)
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

        $wishlistBookIds = $request->user()
            ? $request->user()->wishlistBooks()->pluck('book_id')->toArray()
            : [];

        return view('category-template', [
            'books' => $books,
            'categoryTitle' => $category?->name ?? 'All Books',
            'categorySubtitle' => ($searchName !== '' || $searchAuthor !== '' || $searchIsbn !== '' || $searchQuery !== '')
                ? trim(sprintf(
                    'Results%s%s%s%s',
                    $searchName !== '' ? ' for name "' . $searchName . '"' : '',
                    $searchAuthor !== '' ? ' by author "' . $searchAuthor . '"' : '',
                    $searchIsbn !== '' ? ' for ISBN "' . $searchIsbn . '"' : '',
                    $searchQuery !== '' && $searchName === '' ? ' matching "' . $searchQuery . '"' : '',
                ))
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
            'wishlistBookIds' => $wishlistBookIds,
            'searchQuery' => $searchQuery,
        ]);
    }
}