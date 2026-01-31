<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use App\Traits\HasFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class CategoryController extends Controller
{
    use HasFile;
    public function index(): Response
    {
        $categories = Category::query()->select(['id','name','slug','cover','created_at'])->get();

        return inertia('Admin/Categories/Index', [
            'categories' => CategoryResource::collection($categories),
            'page_settings' => [

                'title' => 'Kategori',
                'subtitle' => 'Menampilkan semua data kategori yang tersedia'
            ]
        ]);

    }
    public function create(): Response
    {
        $categories = Category::query()->select(['id','name','slug','cover','created_at'])->get();

        return inertia('Admin/Categories/Create', [
            'page_settings' => [

                'title' => 'Tambah Kategori',
                'subtitle' => 'Buat kategori baru disini',
                'methods' =>'POST',
                'action' => route('admin.categories.store')
            ]
        ]);

    }


    public function store(AdminRequest $request): RedirectResponse
    {
        try {
            //code...
            Category::create([
                'name' => $name = $request->name,
                'slug' => str()->lower(str()->slug($name). str()->random(4)),
                'description' => $request->description,
                'cover' => $this->uploadFile($request, 'cover','categories')
            ]);
            flashMessage(MessageType::CREATED->message('Kategori'));

            return to_route('admin.categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            flashMessage(MessageType::ERROR->message(error: $th->getMessage(), ), 'error');
            return back();
        }
    }
}
