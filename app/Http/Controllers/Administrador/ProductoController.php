<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function dropzone(Producto $producto, Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);

        $urlImagen = Storage::put('productos', $request->file('file'));

        $producto->imagenes()->create([
            'imagen_ruta' => $urlImagen,
            'posicion' => $producto->imagenes()->count() + 1,
        ]);
    }

    public function redirigirQr(Producto $producto)
    {
        return redirect()->route('producto.index', $producto->slug);
    }
}
