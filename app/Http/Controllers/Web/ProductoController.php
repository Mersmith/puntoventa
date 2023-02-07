<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function mostrar(Producto $producto)
    {
        return view('web.producto.producto-index', compact('producto'));
    }
}
