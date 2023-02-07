<?php

namespace App\Http\Livewire\Administrador\Compra;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompraCrearLivewire extends Component
{
    public $proveedores, $productos;

    public $producto = "";

    public $proveedor_id = "";

    public
        $impuesto = 18,
        $cantidad = 1,
        $precio = 1;

    public $carrito = [];

    public function mount()
    {
        $this->proveedores = Proveedor::all();
        $this->productos = Producto::select('id', 'nombre')->get();
    }

    public function agregarCarrito()
    {
        if ($this->producto && $this->proveedor_id) {

            //$productoCarrito = (object) json_decode($this->producto, true);
            $productoCarrito = json_decode($this->producto, true);

            foreach ($this->carrito as $value) {
                if ($value["id"] == $productoCarrito["id"]) {
                    $this->emit('mensajeError', "Ya existe el producto.");
                    return;
                }
            }

            $extraerKeys = ['id', 'nombre'];
            $productoFiltrado = array_intersect_key($productoCarrito, array_flip($extraerKeys));

            $precioCompra = $this->precio;
            $cantidadCompra = $this->cantidad;

            $productoFiltrado["producto_id"] = $productoFiltrado['id'];
            $productoFiltrado["precio"] = $precioCompra;
            $productoFiltrado["cantidad"] = $cantidadCompra;
            $productoFiltrado["subtotal_compra"] = $cantidadCompra * $precioCompra;
            //$productoFiltrado->{"precio_compra"} = (float)$precioCompra;
            //$productoFiltrado->{"cantidad_compra"} = (int)$cantidadCompra;

            array_push($this->carrito, $productoFiltrado);

            $this->reset(['producto', 'cantidad', 'precio']);
        } else {
            $this->emit('mensajeError', "Falta seleccionar.");
        }
    }

    public function eliminarProductoCarrito($index)
    {
        array_splice($this->carrito, $index, 1);
    }

    public function crearCompra()
    {
        $array_columna = 'subtotal_compra';
        $subTotal = array_sum(array_column($this->carrito, $array_columna));
        $totalPagar = $subTotal + ($subTotal * $this->impuesto) / 100;

        $nuevaCompra = new Compra();
        $nuevaCompra->total = $totalPagar;
        $nuevaCompra->impuesto = $this->impuesto;
        $nuevaCompra->proveedor_id = $this->proveedor_id;
        $nuevaCompra->user_id = Auth::user()->id;

        $nuevaCompra->save();

        $nuevaCompra->compraDetalle()->createMany($this->carrito);

        $this->emit('mensajeCreado', "Creado.");
    }

    public function render()
    {
        return view('livewire.administrador.compra.compra-crear-livewire')->layout('layouts.administrador.index');
    }
}
