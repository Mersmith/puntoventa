<?php

namespace App\Http\Livewire\Web\Producto;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AgregarCarritoSinVariacion extends Component
{
    public $producto;
    public $stockProducto;
    public $cantidadCarrito = 1;
    public $opciones = ['color_id' => null, 'medida_id' => null, 'cantidad' => null];

    public function mount()
    {
        $this->stockProducto = calculandoProductosDisponibles($this->producto->id);

        $this->opciones["imagen"] = $this->producto->imagenes->count()  ? Storage::url($this->producto->imagenes->first()->imagen_ruta) : asset('imagenes/producto/sin_foto_producto.png');
        $this->opciones["puntos_ganar"] = $this->producto->puntos_ganar;
        $this->opciones["puntos_tope"] = $this->producto->puntos_tope;
        $this->opciones["cantidad"] = $this->producto->stock_total;
    }

    public function disminuir()
    {
        $this->cantidadCarrito = $this->cantidadCarrito - 1;
    }

    public function aumentar()
    {
        $this->cantidadCarrito = $this->cantidadCarrito + 1;
    }

    public function agregarProducto()
    {
        Cart::instance('shopping')->add(
            [
                'id' => $this->producto->id,
                'name' => $this->producto->nombre,
                'qty' => $this->cantidadCarrito,
                'price' => $this->producto->precio_venta,
                'weight' => 550,
                'options' => $this->opciones,
            ]
        );
        $this->stockProducto = calculandoProductosDisponibles($this->producto->id);

        $this->reset('cantidadCarrito');

        $this->emitTo('web.menu.menu-carrito', 'render');
    }

    public function render()
    {
        return view('livewire.web.producto.agregar-carrito-sin-variacion');
    }
}
