<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;

class UserController extends Controller
{
    //
    public function index(): Response
    {
        $users = User::query()->select(['id','name','username','email','phone_number','avatar','gender','date_of_birth','address','created_at'])->filter(request()->only(['search']))->sorting(request()->only(['field','direction']))->paginate(request()->load ?? 10)->withQueryString();
        return inertia('Admin/Users/Index', [
            'users'=>UserResource::collection($users)->additional([
                'meta'=>[
                    'has_pages'=>$users->hasPages(),
                ]
            ]),
            'page_settings'=>[
                'title'=>'User',
                'subtitle'=>'Menampilkan semua user yang tersedia pada platform ini'
            ],
            'state'=>[
                'page'=> request()->page ?? 1,
                'search'=>request()->search ?? '',
                'load'=>10
            ]
        ]);
    }
}
