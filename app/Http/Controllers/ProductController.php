<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Request $request, Book $book): View
    {
        $book->loadMissing(['authors', 'categories', 'publisher']);

        // Fetch 5 books from the trending category
        $recommendedBooks = Book::query()
            ->with('authors')
            ->whereHas('categories', fn ($q) => $q->where('slug', 'trending'))
            ->where('id', '!=', $book->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        // If not enough trending books, fill with any other books
        if ($recommendedBooks->count() < 5) {
            $fallbackBooks = Book::query()
                ->with('authors')
                ->where('id', '!=', $book->id)
                ->whereNotIn('id', $recommendedBooks->pluck('id'))
                ->inRandomOrder()
                ->limit(5 - $recommendedBooks->count())
                ->get();

            $recommendedBooks = $recommendedBooks->concat($fallbackBooks);
        }

        $cart = collect((array) $request->session()->get('cart', []))
            ->mapWithKeys(fn ($quantity, $bookId) => [(int) $bookId => max(0, (int) $quantity)]);

        return view('product', [
            'book' => $book,
            'recommendedBooks' => $recommendedBooks,
            'cartQty' => (int) ($cart[$book->id] ?? 0),
        ]);
    }
}
