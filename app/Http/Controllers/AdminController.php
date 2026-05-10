<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $books = Book::query()
            ->with(['authors', 'categories'])
            ->when($search !== '', function ($query) use ($search) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $search) . '%';
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'ILIKE', $like)
                        ->orWhereHas('authors', fn ($q) => $q->where('full_name', 'ILIKE', $like));
                });
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin', [
            'books'      => $books,
            'search'     => $search,
            'totalCount' => Book::count(),
        ]);
    }

    public function createProduct(): View
    {
        return view('admin-product', [
            'book'       => null,
            'categories' => Category::orderBy('name')->get(),
            'publishers' => Publisher::orderBy('name')->get(),
            'genres'     => $this->distinctGenres(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:500'],
            'isbn'             => ['required', 'regex:/^[0-9]{13}$/', 'unique:books,isbn'],
            'description'      => ['nullable', 'string'],
            'genre'            => ['nullable', 'string', 'max:100'],
            'price'            => ['required', 'numeric', 'min:0'],
            'discount'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'publication_date' => ['nullable', 'date'],
            'language'         => ['nullable', 'string', 'max:100'],
            'pages'            => ['nullable', 'integer', 'min:1'],
            'publisher_name'   => ['nullable', 'string', 'max:255'],
            'stock'            => ['nullable', 'integer', 'min:0'],
            'authors'          => ['required', 'array', 'min:1'],
            'authors.*'        => ['required', 'string', 'max:255'],
            'categories'       => ['nullable', 'array'],
            'categories.*'     => ['integer', 'exists:categories,id'],
            'cover_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $book = Book::create([
            'isbn'             => $data['isbn'],
            'title'            => $data['title'],
            'description'      => $data['description'] ?? null,
            'genre'            => $data['genre'] ?? null,
            'price'            => $data['price'],
            'discount'         => $data['discount'] ?? 0,
            'publication_date' => $data['publication_date'] ?? null,
            'language'         => $data['language'] ?? null,
            'pages'            => $data['pages'] ?? null,
            'publisher_id'     => $this->resolvePublisher($data['publisher_name'] ?? null),
            'stock'            => $data['stock'] ?? 0,
            'cover_image_url'  => $this->storeCoverImage($request, $data['isbn']),
        ]);

        $book->authors()->sync($this->resolveAuthorIds($data['authors']));
        $book->categories()->sync($data['categories'] ?? []);

        return redirect()->route('admin.index')->with('success', 'Book added successfully.');
    }

    public function editProduct(Book $book): View
    {
        $book->load(['authors', 'categories', 'publisher']);

        return view('admin-product', [
            'book'       => $book,
            'categories' => Category::orderBy('name')->get(),
            'publishers' => Publisher::orderBy('name')->get(),
            'genres'     => $this->distinctGenres(),
        ]);
    }

    public function updateProduct(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:500'],
            'isbn'             => ['required', 'regex:/^[0-9]{13}$/', Rule::unique('books', 'isbn')->ignore($book->id)],
            'description'      => ['nullable', 'string'],
            'genre'            => ['nullable', 'string', 'max:100'],
            'price'            => ['required', 'numeric', 'min:0'],
            'discount'         => ['nullable', 'numeric', 'min:0', 'max:100'],
            'publication_date' => ['nullable', 'date'],
            'language'         => ['nullable', 'string', 'max:100'],
            'pages'            => ['nullable', 'integer', 'min:1'],
            'publisher_name'   => ['nullable', 'string', 'max:255'],
            'stock'            => ['nullable', 'integer', 'min:0'],
            'authors'          => ['required', 'array', 'min:1'],
            'authors.*'        => ['required', 'string', 'max:255'],
            'categories'       => ['nullable', 'array'],
            'categories.*'     => ['integer', 'exists:categories,id'],
            'cover_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $book->update([
            'isbn'             => $data['isbn'],
            'title'            => $data['title'],
            'description'      => $data['description'] ?? null,
            'genre'            => $data['genre'] ?? null,
            'price'            => $data['price'],
            'discount'         => $data['discount'] ?? 0,
            'publication_date' => $data['publication_date'] ?? null,
            'language'         => $data['language'] ?? null,
            'pages'            => $data['pages'] ?? null,
            'publisher_id'     => $this->resolvePublisher($data['publisher_name'] ?? null),
            'stock'            => $data['stock'] ?? 0,
            'cover_image_url'  => $this->storeCoverImage($request, $data['isbn']) ?? $book->getRawOriginal('cover_image_url'),
        ]);

        $book->authors()->sync($this->resolveAuthorIds($data['authors']));
        $book->categories()->sync($data['categories'] ?? []);

        return redirect()->route('admin.index')->with('success', 'Book updated successfully.');
    }

    public function profile(Request $request): View
    {
        return view('admin-profile', [
            'user'            => $request->user(),
            'totalBooks'      => Book::count(),
            'outOfStock'      => Book::where('stock', 0)->count(),
            'totalCategories' => Category::count(),
            'totalAuthors'    => Author::count(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user        = $request->user();
        $hasPassword = ! empty($user->password);

        $rules = [
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'        => ['nullable', 'string', 'max:40'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ];

        if ($hasPassword) {
            $rules['current_password'] = ['nullable', 'required_with:new_password', 'current_password'];
        }

        $validated = $request->validate($rules);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        if (! empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('admin.profile')->with('status', 'Profile updated successfully.');
    }

    public function destroyProduct(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('admin.index')->with('success', 'Book deleted.');
    }

    private function resolvePublisher(?string $name): ?int
    {
        if (blank($name)) {
            return null;
        }

        return Publisher::firstOrCreate(['name' => trim($name)])->id;
    }

    private function resolveAuthorIds(array $names): array
    {
        $ids = [];
        foreach ($names as $name) {
            $name = trim($name);
            if ($name === '') {
                continue;
            }
            $ids[] = Author::firstOrCreate(['full_name' => $name])->id;
        }

        return $ids;
    }

    private function storeCoverImage(Request $request, string $isbn): ?string
    {
        if (! $request->hasFile('cover_image')) {
            return null;
        }

        $file     = $request->file('cover_image');
        $filename = $isbn . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('img'), $filename);

        return $filename;
    }

    private function distinctGenres()
    {
        return Book::query()
            ->whereNotNull('genre')
            ->where('genre', '!=', '')
            ->select('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');
    }
}
