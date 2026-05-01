<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->normalizeCart($this->getCart($request));
        $this->storeCart($request, $cart);
        $bookIds = array_keys($cart);

        $books = Book::query()
            ->with('authors')
            ->whereIn('id', $bookIds)
            ->get()
            ->keyBy('id');

        $items = collect($cart)
            ->map(function (int $quantity, int|string $bookId) use ($books) {
                $book = $books->get((int) $bookId);

                if (! $book) {
                    return null;
                }

                $unitPrice = (float) $book->discounted_price;

                return [
                    'book' => $book,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $unitPrice * $quantity,
                ];
            })
            ->filter()
            ->values();

        $total = (float) $items->sum('line_total');

        return view('cart', [
            'items' => $items,
            'total' => $total,
            'itemCount' => (int) $items->sum('quantity'),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $bookId = (int) $validated['book_id'];
        $quantityToAdd = (int) ($validated['quantity'] ?? 1);
        $book = Book::query()->find($bookId);

        if (! $book || (int) $book->stock <= 0) {
            return back();
        }

        $quantityToAdd = min($quantityToAdd, (int) $book->stock);

        $cart = $this->getCart($request);
        $cart[$bookId] = min((int) $book->stock, ($cart[$bookId] ?? 0) + $quantityToAdd);

        $this->storeCart($request, $cart);

        return back();
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $bookId = (int) $validated['book_id'];
        $quantity = (int) $validated['quantity'];
        $book = Book::query()->find($bookId);

        if (! $book || (int) $book->stock <= 0) {
            $cart = $this->getCart($request);
            unset($cart[$bookId]);
            $this->storeCart($request, $cart);

            return back();
        }

        $quantity = min($quantity, (int) $book->stock);

        $cart = $this->getCart($request);

        if ($quantity === 0) {
            unset($cart[$bookId]);
        } else {
            $cart[$bookId] = $quantity;
        }

        $this->storeCart($request, $cart);

        return back();
    }

    public function remove(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
        ]);

        $bookId = (int) $validated['book_id'];
        $cart = $this->getCart($request);
        unset($cart[$bookId]);

        $this->storeCart($request, $cart);

        return back();
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');

        return back();
    }

    /**
     * @return array<int, int>
     */
    private function getCart(Request $request): array
    {
        $raw = $request->session()->get('cart', []);

        if (! is_array($raw)) {
            return [];
        }

        $normalized = [];

        foreach ($raw as $bookId => $quantity) {
            $id = (int) $bookId;
            $qty = (int) $quantity;

            if ($id > 0 && $qty > 0) {
                $normalized[$id] = min(99, $qty);
            }
        }

        return $normalized;
    }

    /**
     * @param  array<int, int>  $cart
     * @return array<int, int>
     */
    private function normalizeCart(array $cart): array
    {
        if ($cart === []) {
            return [];
        }

        $stocks = Book::query()
            ->whereIn('id', array_keys($cart))
            ->pluck('stock', 'id')
            ->map(fn ($stock) => max(0, (int) $stock))
            ->all();

        $normalized = [];

        foreach ($cart as $bookId => $quantity) {
            $id = (int) $bookId;
            $qty = max(0, (int) $quantity);
            $stock = (int) ($stocks[$id] ?? 0);

            if ($id > 0 && $qty > 0 && $stock > 0) {
                $normalized[$id] = min($qty, $stock);
            }
        }

        return $normalized;
    }

    /**
     * @param  array<int, int>  $cart
     */
    private function storeCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }
}
