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

        $relatedBooks = Book::query()
            ->with('authors')
            ->where('id', '!=', $book->id)
            ->when(
                filled($book->genre),
                fn ($query) => $query->where('genre', $book->genre)
            )
            ->inRandomOrder()
            ->limit(6)
            ->get();

        if ($relatedBooks->count() < 6) {
            $fallbackBooks = Book::query()
                ->with('authors')
                ->where('id', '!=', $book->id)
                ->whereNotIn('id', $relatedBooks->pluck('id'))
                ->inRandomOrder()
                ->limit(6 - $relatedBooks->count())
                ->get();

            $relatedBooks = $relatedBooks->concat($fallbackBooks);
        }

        $cart = collect((array) $request->session()->get('cart', []))
            ->mapWithKeys(fn ($quantity, $bookId) => [(int) $bookId => max(0, (int) $quantity)]);

        return view('product', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'cartQty' => (int) ($cart[$book->id] ?? 0),
        ]);
    }
}
