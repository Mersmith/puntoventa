<?php

namespace App\Http\Livewire\Web\Producto;

use Livewire\Component;
use App\Models\Medida;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AgregarCarritoVariacionMedida extends Component
{
    public $producto, $medidas,  $medida_id = "";
    public $stockProducto = 0;
    public $cantidadCarrito = 1;
    public $opciones = ['color_id' => null, 'cantidad' => null];

    public function mount()
    {
        $this->medidas= $this->producto->medida_producto;

        $this->opciones["imagen"] = $this->producto->imagenes->count()  ? Storage::url($this->producto->imagenes->first()->imagen_ruta) : asset('imagenes/producto/sin_foto_producto.png');
        $this->opciones["puntos_ganar"] = $this->producto->puntos_ganar;
        $this->opciones["puntos_tope"] = $this->producto->puntos_tope;
    }

    public function updatedMedidaId($value)
    {
        $dataMedida = Medida::find($value);
        $this->stockProducto = calculandoProductosDisponibles($this->producto->id, null, $dataMedida->id);
        $this->opciones["color_id"] = 1;
        $this->opciones['color'] = "ninguno";
        $this->opciones['medida_id'] = $dataMedida->id;
        $this->opciones['medida'] = $dataMedida->nombre;
        $this->opciones["cantidad"] = calculandoStockProductos($this->producto->id, null, $dataMedida->id);

        $this->reset('cantidadCarrito');
    }


    public function render()
    {
        return view('livewire.web.producto.agregar-carrito-variacion-medida');
    }
}
