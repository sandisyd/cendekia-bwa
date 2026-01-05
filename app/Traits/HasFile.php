<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HasFile

{

    public function uploadFile(Request $request, string $column, string $file): ?string
    {
        return $request->hasFile($column) ? $request->file($column)->store($file) : null;
    }

    public function updateFile(Request $request, Model $model, string $column, string $file): ?string
    {
        if($request->hasFile($column))
        {
            if($model->$column)
            {
                Storage::delete($model->$column);
            }

            $thumbnail = $request->file($column)->store($file);
        }else{
            $thumbnail = $model->$column;
        }
        return $thumbnail;
    }
    public function deleteFile(Model $model, string $column): void
    {
        if($model->$column)
        {
            Storage::delete($model->$column);
        }
    }
}