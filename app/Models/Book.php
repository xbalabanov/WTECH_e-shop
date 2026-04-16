<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'genre',
        'price',
        'discount',
        'publication_date',
        'language',
        'pages',
        'publisher_id',
        'stock',
        'cover_image_url',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount' => 'decimal:2',
            'publication_date' => 'date',
        ];
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function getDiscountedPriceAttribute(): float
    {
        return max(0, (float) $this->price - ((float) $this->price * ((float) $this->discount / 100)));
    }
}