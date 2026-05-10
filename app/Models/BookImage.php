<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookImage extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['book_id', 'filename'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
