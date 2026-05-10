<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Request $request, Book $book): View
    {
        $book->loadMissing(['authors', 'categories', 'publisher']);

        $recommendedBooks = Book::query()
            ->with('authors')
            ->whereHas('categories', fn ($q) => $q->where('slug', 'trending'))
            ->where('id', '!=', $book->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

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

        $user = $request->user();

        $cartRaw = $user
            ? Cart::getForUser($user)
            : (array) $request->session()->get('cart', []);

        $cart = collect($cartRaw)
            ->mapWithKeys(fn ($quantity, $bookId) => [(int) $bookId => max(0, (int) $quantity)]);

        $isWishlisted = $user
            ? $user->wishlistBooks()->where('book_id', $book->id)->exists()
            : false;

        $reviews = $book->reviews()->with('user')->latest('created_at')->get();
        $averageRating = $reviews->avg('rating');
        $userReview = $user ? $reviews->firstWhere('user_id', $user->id) : null;

        return view('product', [
            'book' => $book,
            'recommendedBooks' => $recommendedBooks,
            'cartQty' => (int) ($cart[$book->id] ?? 0),
            'isWishlisted' => $isWishlisted,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'userReview' => $userReview,
        ]);
    }
}
