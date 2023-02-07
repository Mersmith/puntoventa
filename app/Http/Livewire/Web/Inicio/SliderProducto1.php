<?php

namespace App\Http\Livewire\Web\Inicio;

use App\Models\Producto;
use Livewire\Component;

class SliderProducto1 extends Component
{
    public $slider1 = "1";
    public $productos = [];

    public function loadProductos()
    {
        $this->productos = Producto::limit(8)->get();

        $this->emit('gliderSliderProducto', $this->slider1);
    }

    public function render()
    {
        return view('livewire.web.inicio.slider-producto1');
    }
}
