<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnBookCheck extends Model
{
    //
    protected $fillable = [
        "return_book_id",
        "condition",
        "notes",
    ];

    protected $casts = [
        "condition" => ReturnBookCondition::class,
    ];


    public function returnBook(): BelongsTo
    {
        return $this->belongsTo(ReturnBook::class);
    
    
    }

    
}
