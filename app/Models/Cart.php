<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * @return array<int, int>
     */
    public static function getForUser(User $user): array
    {
        $cart = static::where('user_id', $user->id)->with('items')->first();

        if (! $cart) {
            return [];
        }

        return $cart->items
            ->mapWithKeys(fn (CartItem $item) => [(int) $item->book_id => (int) $item->quantity])
            ->all();
    }

    /**
     * @param  array<int, int>  $cartData
     */
    public static function saveForUser(User $user, array $cartData): void
    {
        $cart = static::firstOrCreate(['user_id' => $user->id]);

        $cart->items()->delete();

        foreach ($cartData as $bookId => $quantity) {
            $bookId   = (int) $bookId;
            $quantity = (int) $quantity;

            if ($bookId > 0 && $quantity > 0) {
                $cart->items()->create(['book_id' => $bookId, 'quantity' => $quantity]);
            }
        }

        $cart->touch();
    }

    public static function clearForUser(User $user): void
    {
        $cart = static::where('user_id', $user->id)->first();
        $cart?->items()->delete();
    }
}
