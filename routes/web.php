<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Str;
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

Route::get('/checkout.html', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::middleware('guest')->group(function () {
    Route::get('/login.html', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register.html', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/profile.html', [ProfileController::class, 'index'])->name('profile');
    Route::get('/order/{order}', [ProfileController::class, 'show'])->name('order.show');
    Route::get('/profile-wishlist.html', [WishlistController::class, 'index'])->name('profile.wishlist');
    Route::get('/profile-settings.html', [ProfileSettingsController::class, 'edit'])->name('profile.settings');
    Route::post('/profile-settings.html', [ProfileSettingsController::class, 'update'])->name('profile.settings.update');
    Route::post('/wishlist/{book}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{book}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin.html', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/profile.html', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/product/create.html', [AdminController::class, 'createProduct'])->name('admin.product.create');
    Route::post('/admin/product', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::get('/admin/product/{book}/edit.html', [AdminController::class, 'editProduct'])->name('admin.product.edit');
    Route::put('/admin/product/{book}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/product/{book}', [AdminController::class, 'destroyProduct'])->name('admin.product.destroy');
});
