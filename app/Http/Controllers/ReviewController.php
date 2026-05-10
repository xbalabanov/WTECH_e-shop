<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();

        if (Review::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
            return back()->with('error', 'You have already reviewed this book.');
        }

        Review::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Review posted!');
    }

    public function destroy(Request $request, Book $book): RedirectResponse
    {
        $review = Review::where('user_id', $request->user()->id)
            ->where('book_id', $book->id)
            ->firstOrFail();

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
