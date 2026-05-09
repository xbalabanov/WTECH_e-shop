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
        $user = $request->user();

        $books = $user
            ?->wishlistedBooks()
            ->with(['authors', 'publisher'])
            ->orderBy('title')
            ->get() ?? collect();

        return view('profile-wishlist', [
            'books' => $books,
            'wishlistBookIds' => $books->pluck('id')->all(),
            'wishlistCount' => $books->count(),
        ]);
    }

    public function store(Request $request, Book $book): RedirectResponse
    {
        $request->user()->wishlistedBooks()->syncWithoutDetaching([$book->id]);

        return back();
    }

    public function destroy(Request $request, Book $book): RedirectResponse
    {
        $request->user()->wishlistedBooks()->detach($book->id);

        return back();
    }
}