<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'book_code'=>$this->book_code,
            'slug'=>$this->slug,
            'title'=>$this->title,
            'author'=>$this->author,
            'publication_year'=>$this->publication_year,
            'isbn'=>$this->isbn,
            'language'=>$this->language,
            'synopsis'=>$this->synopsis,
            'number_of_pages'=>$this->number_of_pages,
            'status'=>$this->status,
            'cover'=>$this->cover ? Storage::url($this->cover) : null,
            'price'=>number_format($this->price, 0, ',', '.'),
            'category'=>[
                'id'=>$this->category?->id,
                'name'=>$this->category?->name
            ],
            'publisher'=>[
                'id'=>$this->publisher?->id,
                'name'=>$this->publisher?->name
            ],
            'created_at'=>$this->created_at->format('d M Y'),
            'stock'=>[
                'total'=>$this->stock?->total,
                'available'=>$this->stock?->available,
                'borrow'=>$this->stock?->borrow,
                'lost'=>$this->stock?->lost,
                'damaged'=>$this->stock?->damaged
            ]
        ];
    }
}
