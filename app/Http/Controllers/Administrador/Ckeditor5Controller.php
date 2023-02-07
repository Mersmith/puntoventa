<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Ckeditor5Controller extends Controller
{
    public function upload(Request $request)
    {
        $path = Storage::put('ckeditor', $request->file('upload'));

        return [
            'url' => Storage::url($path)
        ];
    }
}
