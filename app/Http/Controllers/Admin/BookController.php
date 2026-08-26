<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookLanguage;
use App\Enums\BookStatus;
use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Http\Resources\Admin\BookResource;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Traits\HasFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class BookController extends Controller
{
    //
    use HasFile;

    public function index(): Response{
        $books = Book::query()->select(['id', 'book_code', 'title','slug','author', 'publication_year','isbn','language','number_of_pages','status','price','category_id','publisher_id','created_at'])->filter(request()->only(['search']))->sorting(request()->only(['field','direction']))->with(['category','stock','publisher'])->latest('created_at')->paginate(request()->load ?? 10)->withQueryString();

        return inertia('Admin/Books/Index', [
            'books'=>BookResource::collection($books)->additional([
                'meta'=>[
                    'has_pages'=>$books->hasPages(),
                ]
            ]),
            'page_settings'=>[
                'title'=>'Buku',
                'subtitle'=>'Menampilkan semua data buku yang tersedia pada platform ini'
            ],
            'state'=>[
                'page'=> request()->page ?? 1,
                'search'=>request()->search ?? '',
                'load'=>10
            ]
        ]);
    }


    public function create(): Response {
        return inertia('Admin/Books/Create',[
            'page_settings'=>[
                'title'=>'Tambah Buku',
                'subtitle'=>'Buat buku baru disini',
                'method'=>'POST',
                'action'=>route('admin.books.store')
            ],
            'page_data'=>[
                'publicationYears' => range(2000, now()->year),
                'languages' => BookLanguage::options(),
                'categories' => Category::query()->select(['id','name'])->get()->map(fn($item)=>[
                    'value'=>$item->id,
                    'label'=>$item->name
                ]),
                'publishers' => Publisher::query()->select(['id','name'])->get()->map(fn($item)=>[
                    'value'=>$item->id,
                    'label'=>$item->name
                ]),
            ]
        ]);
    }

    public function store (BookRequest $r): RedirectResponse {
        try {
            //code...
             Book::create([
                'book_code' => str()->random(6),
                'title'=> $title = $r->title,
                'slug'=> str()->lower(str()->slug($title). str()->random(4)),
                'author'=> $r->author,
                'publication_year'=>$r->publication_year,
                'isbn'=>$r->isbn,
                'language'=>$r->language,
                'synopsis'=>$r->synopsis,
                'number_of_pages'=>$r->number_of_pages,
                'status'=>$r->total > 0 ? BookStatus::AVAILABLE->value : BookStatus::UNAVAILABLE->value,
                'cover'=>$this->uploadFile($r, 'cover','books'),
                'price'=>$r->price,
                'category_id'=>$r->category_id,
                'publisher_id'=>$r->publisher_id


            ]);

            
            flashMessage(MessageType::CREATED->message('Buku'));
            return to_route('admin.books.index');
        } catch (\Throwable $th) {
            //throw $th;
            flashMessage(MessageType::ERROR->message(error: $th->getMessage()), 'error');
            return back();
        }
    }
}
