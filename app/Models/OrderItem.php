<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function getLineTotalAttribute(): float
    {
        return (float) ($this->attributes['price'] ?? 0);
    }

    public function getUnitPriceAttribute(): float
    {
        $quantity = max(1, (int) ($this->attributes['quantity'] ?? 1));

        return $this->getLineTotalAttribute() / $quantity;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
