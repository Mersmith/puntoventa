<?php

namespace App\Http\Livewire\Web\Producto;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AgregarCarritoVariacionColor extends Component
{
    public $producto, $colores, $color_id = "";
    public $stockProducto = 0;
    public $cantidadCarrito = 1;
    public $opciones = ['medida_id' => null, 'cantidad' => null];

    public function mount()
    {
        $this->colores = $this->producto->colores;

        $this->opciones["imagen"] = $this->producto->imagenes->count()  ? Storage::url($this->producto->imagenes->first()->imagen_ruta) : asset('imagenes/producto/sin_foto_producto.png');
        $this->opciones["puntos_ganar"] = $this->producto->puntos_ganar;
        $this->opciones["puntos_tope"] = $this->producto->puntos_tope;
    }
    
    public function updatedColorId($value)
    {
        $color = $this->producto->colores->find($value);
        $this->stockProducto = calculandoProductosDisponibles($this->producto->id, $color->id);
        $this->opciones["color_id"] = $color->id;
        $this->opciones["color"] = $color->nombre;
        $this->opciones["cantidad"] = calculandoStockProductos($this->producto->id, $color->id);
        $this->reset('cantidadCarrito');
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
        $this->stockProducto = calculandoProductosDisponibles($this->producto->id, $this->color_id);

        $this->reset('cantidadCarrito');

        $this->emitTo('frontend.menu.menu-carrito', 'render');
    }

    public function render()
    {
        return view('livewire.web.producto.agregar-carrito-variacion-color');
    }
}
