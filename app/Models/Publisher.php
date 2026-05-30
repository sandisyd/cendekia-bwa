<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Publisher extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        "name",
        "slug",
        "address",
        "phone",
        "email",
        "logo",
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function scopeFilter(Builder $query, array $filters): void {
        $query->when($filters['search'] ?? null, function ($query, $search){
            $query->where(function($query) use($search){
                $query->whereAny([
                    'name',
                    'slug',
                    'email',
                    'phone',

                ], 'REGEXP', $search);
            });
        });
    }

    public function scopeSorting(Builder $query, array $sorts): void {
        $query->when($shorts['field'] ?? null && $sorts['direction'] ?? null, function($query) use($sorts){
            $query->orderBy($sorts['field'], $sorts['direction']);
        });
    }
}
