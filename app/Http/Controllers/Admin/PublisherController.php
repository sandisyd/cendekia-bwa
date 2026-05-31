<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Resources\Admin\PublisherResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Publisher;
use Inertia\Response;


class PublisherController extends Controller
{
    //
    public function index(): Response {
        $publishers = Publisher::query()->select(['id','name','slug','address','email','phone','created_at'])
        ->filter(request()->only(['search']))
        ->sorting(request()->only(['field','direction']))
        ->paginate(request()->load ?? 10)->withQueryString();

        return inertia('Admin/Publishers/Index', [
            'publishers'=> PublisherResource::collection($publishers)->additional([
                'meta' => [
                    'has_pages' => $publishers->hasPages()
                ]
            ]),
            'page_settings' => [
                'title' => 'Penerbit',
                'subtitle' => 'Menampilkan semua data penerbit yang tersedia pada platform ini'
            ],
            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10
            ]
        ]);
    }

    public function create(): Response {
        $publishers = Publisher::query()->select(['id', 'name', 'slug', 'address', 'email', 'phone', 'created_at'])->get();

        return inertia('Admin/Publishers/Create', [
            'page_settings' => [
                'title' => 'Tambah Penerbit',
                'subtitle' => 'Buat penerbit baru disini',
                'methods' => 'POST',
                'action' => route('admin.publishers.create')
            ]
        ]);
    }

    public function store(AdminRequest $request): RedirectResponse {
        try {
            //code...
            Publisher::create([
                'name' => $name = $request->name,
                'slug' => str()->lower(str()->slug($name). str()->random(4)),
                'address' =>  $request->address,
                'email' => $request->email,
                'phone' => $request->phone

            ]);
            flashMessage(MessageType::CREATED->message('Penerbit'));
            return to_route('admin.publishers.index');
        } catch (\Throwable $th) {
            //throw $th;
            flashMessage(MessageType::ERROR->message(error: $th->getMessage(), ), 'error');
            return back();
        }
    }
}
