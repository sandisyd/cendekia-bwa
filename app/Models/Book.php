<?php

namespace App\Models;

use App\Enums\BookLanguage;
use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFilter(Builder $q, array $filters): void {
        $q->when($filters['search'] ?? null, function($query, $search){
            $query->where(function($query) use($search) {
                $query->whereAny([
                    'book_code',
                    'slug',
                    'title',
                    'author',
                    'publication_year',
                    'isbn',
                    'language',
                    'status'
                ], 'REGEXP', $search);
            });
        });
    }

    public function scopeSorting(Builder $q, array $sorting): void {
        $q->when($sorting['field'] ?? null && $sorting['direction'] ?? null, function($query) use($sorting){
            $query->orderBy($sorting['field'], $sorting['direction']);
        });
    }
}
