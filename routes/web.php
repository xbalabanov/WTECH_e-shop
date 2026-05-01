<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\CategoryController;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/homepage.html');
});

Route::get('/homepage.html', function () {
    $books = Book::query()
        ->with('authors')
        ->orderByDesc('publication_date')
        ->get();

    return view('homepage', [
        'trendingBooks' => $books->sortByDesc(fn (Book $book) => (float) $book->discount)->values()->take(6),
        'newArrivalBooks' => $books->take(6)->values(),
        'comingSoonBooks' => $books->reverse()->values()->take(6),
        'recommendedBooks' => $books->sortBy('price')->values()->take(6),
        'bookOfWeek' => $books->isNotEmpty() ? $books->random() : null,
    ]);
})->name('home');
Route::get('/category-template.html', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/product/{book}.html', [ProductController::class, 'show'])->name('products.show');
Route::get('/cart.html', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/categories-menu.json', function () {
    return Category::query()
        ->orderBy('name')
        ->get(['name', 'slug']);
});

Route::get('/cart-summary.json', function () {
    $cart = (array) session('cart', []);
    $itemCount = collect($cart)->sum(fn ($qty) => max(0, (int) $qty));

    return response()->json([
        'item_count' => (int) $itemCount,
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login.html', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register.html', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::view('/profile.html', 'profile')->name('profile');
    Route::get('/profile-settings.html', [ProfileSettingsController::class, 'edit'])->name('profile.settings');
    Route::post('/profile-settings.html', [ProfileSettingsController::class, 'update'])->name('profile.settings.update');

});
