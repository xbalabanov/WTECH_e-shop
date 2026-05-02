<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        return view('profile-wishlist', [
            'wishlistBooks' => $request->user()
                ->wishlistBooks()
                ->with('authors')
                ->orderBy('title')
                ->get(),
        ]);
    }

    public function store(Request $request, Book $book): RedirectResponse
    {
        $request->user()->wishlistBooks()->syncWithoutDetaching([$book->id]);

        return back()->with('status', 'Added to your wishlist.');
    }

    public function destroy(Request $request, Book $book): RedirectResponse
    {
        $request->user()->wishlistBooks()->detach($book->id);

        return back()->with('status', 'Removed from your wishlist.');
    }
}