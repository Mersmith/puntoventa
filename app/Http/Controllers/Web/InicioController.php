<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Slider;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function __invoke()
    {
        $sliders = Slider::where('estado', '1')->orderBy('posicion', 'asc')->get();
        $categorias = Categoria::all();

        return view('web.inicio.index', compact('sliders', 'categorias'));
    }
}
