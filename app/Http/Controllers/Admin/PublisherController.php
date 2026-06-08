<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\PublisherRequest;
use App\Http\Resources\Admin\PublisherResource;
use App\Traits\HasFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Publisher;
use Inertia\Response;



class PublisherController extends Controller
{
    //
    use HasFile;
    public function index(): Response {
        $publishers = Publisher::query()->select(['id','name','slug','address','email','phone','created_at'])
        ->filter(request()->only(['search']))
        ->latest('created_at')
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
        // $publishers = Publisher::query()->select(['id', 'name', 'slug', 'address', 'email', 'phone', 'created_at'])->get();

        return inertia('Admin/Publishers/Create', [
            'page_settings' => [
                'title' => 'Tambah Penerbit',
                'subtitle' => 'Buat penerbit baru disini',
                'methods' => 'POST',
                'action' => route('admin.publishers.create')
            ]
        ]);
    }

    public function store(PublisherRequest $request): RedirectResponse {
        try {
            //code...
            Publisher::create([
                'name' => $name = $request->name,
                'slug' => str()->lower(str()->slug($name). str()->random(4)),
                'address' =>  $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'logo' => $this->uploadFile($request, 'logo','publishers')

            ]);
            flashMessage(MessageType::CREATED->message('Penerbit'));
            return to_route('admin.publishers.index');
        } catch (\Throwable $th) {
            //throw $th;
            flashMessage(MessageType::ERROR->message(error: $th->getMessage(), ), 'error');
            return back();
        }
    }

    public function edit(Publisher $publisher): Response {
        return inertia('Admin/Publishers/Edit',[
            'page_settings' => [
                'title' => 'Edit Penerbit',
                'subtitle' => 'Edit penerbit disini',
                'methods' => 'PUT',
                'action' => route('admin.publishers.update', $publisher)
            ],
            'publisher' => $publisher
        ]);
    }

    public function update(Publisher $publisher, PublisherRequest $req): RedirectResponse {
        try {
            //code...
            $publisher -> update([
                'name' => $name = $req->name,
                'slug' => $name !== $publisher->name ? str()->lower(str()->slug($name).str()->random(4)) : $publisher->slug,
                'address'=> $req->address,
                'email'=>$req->email,
                'phone'=>$req->phone,
                'logo'=> $this->updateFile($req, $publisher, 'logo', 'publishers')
            ]);
            flashMessage(MessageType::UPDATED->message('Penerbit'));
            return to_route('admin.publishers.index');
        } catch (\Throwable $th) {
            //throw $th;
            flashMessage(MessageType::ERROR->message(error: $th->getMessage()), 'error');
            return back();
        }
    }

    public function destroy(Publisher $publisher): RedirectResponse {
        try {
            //code...
            $this->deleteFile($publisher, 'logo');
            $publisher->delete();
            flashMessage(MessageType::DELETED->message('Penerbit'));
            return to_route('admin.publishers.index');
        } catch (\Throwable $th) {
            //throw $th;
            flashMessage(MessageType::ERROR->message(error: $th->getMessage()), 'error');
            return back();
        }
    }
}
