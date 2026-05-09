<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/homepage.html');
});

Route::get('/homepage.html', function () {
    $trending = Book::query()
        ->whereHas('categories', fn ($q) => $q->where('slug', 'trending'))
        ->with(['authors'])
        ->latest()
        ->take(6)
        ->get();

    $sale = Book::query()
        ->where('discount', '>', 0)
        ->with(['authors'])
        ->orderByDesc('discount')
        ->take(6)
        ->get();

    $newArrivals = Book::query()
        ->with(['authors'])
        ->orderByDesc('publication_date')
        ->take(6)
        ->get();

    $comingSoon = Book::query()
        ->where('publication_date', '>', now())
        ->with(['authors'])
        ->orderBy('publication_date')
        ->take(6)
        ->get();

    $recommended = Book::query()
        ->with(['authors'])
        ->inRandomOrder()
        ->take(6)
        ->get();

    $stats = [
        'books' => Book::query()->count(),
        'authors' => Author::query()->count(),
        'genres' => Book::query()->whereNotNull('genre')->where('genre', '!=', '')->distinct('genre')->count('genre'),
    ];

    return view('homepage', compact('trending', 'sale', 'newArrivals', 'comingSoon', 'recommended', 'stats'));
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

Route::get('/genres-menu.json', function () {
    return Book::query()
        ->whereNotNull('genre')
        ->where('genre', '!=', '')
        ->select('genre')
        ->distinct()
        ->orderBy('genre')
        ->get()
        ->map(function ($row) {
            return [
                'name' => $row->genre,
                'slug' => $row->genre,
            ];
        });
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
    Route::get('/profile-wishlist.html', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{book}.html', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{book}.html', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('/profile-settings.html', [ProfileSettingsController::class, 'edit'])->name('profile.settings');
    Route::post('/profile-settings.html', [ProfileSettingsController::class, 'update'])->name('profile.settings.update');

});
