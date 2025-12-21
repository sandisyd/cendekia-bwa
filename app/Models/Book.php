<?php

namespace App\Models;

use App\Enums\BookLanguage;
use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    //
    protected $fillable = [
        "title",
        "slug",
        "author",
        "publication_year",
        "description",
        "publisher_id",
        "category_id",
        "price",
        "stock",
        "status",
        "cover",
        "language",
        "synopsis",
        "isbn",
        "number_of_pages",
    ];

    protected function casts(): array
    {
        return [
            'status' => BookStatus::class,
            'language' => BookLanguage::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
