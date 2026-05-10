<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cart = $this->resolveCart($request);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Retrieve books from cart
        $items = [];
        $subtotal = 0;

        foreach ($cart as $bookId => $quantity) {
            if ($quantity > 0) {
                $book = Book::with('authors')->find($bookId);
                if ($book) {
                    $effectivePrice = $book->price * (1 - $book->discount / 100);
                    $lineTotal = $effectivePrice * $quantity;
                    $items[] = [
                        'book' => $book,
                        'quantity' => $quantity,
                        'unit_price' => $effectivePrice,
                        'line_total' => $lineTotal,
                    ];
                    $subtotal += $lineTotal;
                }
            }
        }

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        return view('checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request)
    {
        $useDeliveryForBilling = $request->boolean('same_delivery_address');

        $validated = $request->validate([
            // Billing address
            'billing_street' => [Rule::requiredIf(! $useDeliveryForBilling), 'string'],
            'billing_city' => [Rule::requiredIf(! $useDeliveryForBilling), 'string'],
            'billing_postal_code' => [Rule::requiredIf(! $useDeliveryForBilling), 'string'],
            'billing_country' => [Rule::requiredIf(! $useDeliveryForBilling), 'string'],
            'billing_full_name' => 'required|string',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string',

            // Delivery
            'delivery_type' => 'required|in:standard,express',
            'same_delivery_address' => 'boolean',

            // Shipping address
            'shipping_street' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_country' => 'required|string',

            // Payment
            'payment_method' => 'required|in:card,paypal,cash_on_delivery',
        ]);

        $cart = $this->resolveCart($request);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $items = [];
        $subtotal = 0;

        foreach ($cart as $bookId => $quantity) {
            if ($quantity > 0) {
                $book = Book::find($bookId);
                if ($book) {
                    $effectivePrice = $book->price * (1 - $book->discount / 100);
                    $lineTotal = $effectivePrice * $quantity;
                    $items[] = [
                        'book_id' => $bookId,
                        'quantity' => $quantity,
                        'unit_price' => $effectivePrice,
                        'line_total' => $lineTotal,
                    ];
                    $subtotal += $lineTotal;
                }
            }
        }

        // Calculate shipping fee
        $shippingFee = $validated['delivery_type'] === 'express' ? 6.99 : 3.99;
        $total = $subtotal + $shippingFee;

        $user = auth()->user();

        if (! $user) {
            $user = \App\Models\User::where('email', $validated['billing_email'])->first();

            if (! $user) {
                $user = \App\Models\User::create([
                    'full_name' => $validated['billing_full_name'],
                    'email' => $validated['billing_email'],
                    'phone' => $validated['billing_phone'],
                    'password_hash' => null,
                ]);
            }

            Auth::login($user);
        }

        // Use transaction to ensure data consistency
        try {
            $order = DB::transaction(function () use ($validated, $items, $subtotal, $shippingFee, $total, $useDeliveryForBilling, $user) {
                // Create shipping address first. When requested, billing will reuse this address.
                $shippingAddress = Address::create([
                    'street' => $validated['shipping_street'],
                    'city' => $validated['shipping_city'],
                    'postal_code' => $validated['shipping_postal_code'],
                    'country' => $validated['shipping_country'],
                ]);

                if ($useDeliveryForBilling) {
                    $billingAddress = $shippingAddress;
                } else {
                    $billingAddress = Address::create([
                        'street' => $validated['billing_street'],
                        'city' => $validated['billing_city'],
                        'postal_code' => $validated['billing_postal_code'],
                        'country' => $validated['billing_country'],
                    ]);
                }

                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'delivery_type' => $validated['delivery_type'],
                    'billing_address_id' => $billingAddress->id,
                    'shipping_address_id' => $shippingAddress->id,
                    'subtotal' => $subtotal,
                    'shipping_fee' => $shippingFee,
                    'total' => $total,
                    'placed_at' => now(),
                ]);

                // Create order items and decrement stock
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $item['book_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'line_total' => $item['line_total'],
                    ]);
                    Book::where('id', $item['book_id'])->decrement('stock', $item['quantity']);
                }

                // Create payment record
                $paymentStatus = 'pending';
                $paymentProvider = 'stripe'; // Default to stripe for card/paypal

                if ($validated['payment_method'] === 'cash_on_delivery') {
                    $paymentStatus = 'pending';
                    $paymentProvider = 'cash';
                }

                Payment::create([
                    'order_id' => $order->id,
                    'provider' => $paymentProvider,
                    'method' => $validated['payment_method'],
                    'amount' => $total,
                    'status' => $paymentStatus,
                ]);

                return $order;
            });

            // Clear cart from whichever store the user has
            if (auth()->user()) {
                Cart::clearForUser(auth()->user());
            }
            session()->forget('cart');

            // Redirect to order details
            return redirect()->route('order.show', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * @return array<int, int>
     */
    private function resolveCart(Request $request): array
    {
        $user = $request->user();

        if ($user) {
            return Cart::getForUser($user);
        }

        return (array) $request->session()->get('cart', []);
    }
}
