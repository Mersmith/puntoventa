<?php

namespace App\Http\Livewire\Administrador\Producto;

use Livewire\Component;
use App\Models\Medida;
use App\Models\MedidaProducto as Pivot;

class StockVariaMedida extends Component
{
    protected $listeners = ['eliminarVariaMedida'];

    public $algo;
    //Crear
    public $producto, $medida, $stock;

    //Editar
    public $pivot, $pivot_stock;

    public $abierto = false;

    public function traerMarcas()
    {
        $this->algo = Pivot::where('medida_id', $this->medida->id)
            ->where('producto_id', $this->producto->id)
            ->first();
    }

    public function mount()
    {
        $this->traerMarcas();

    }

    public function guardarPivot()
    {
        // $this->validate();

        if ($this->algo) {
            $this->algo->stock = $this->algo->stock + $this->stock;
            $this->algo->save();
        } else {
            //Atach para registrar un registro en una tabla intermedia
            $this->producto->medida_producto()->attach([
                $this->medida->id => [
                    'stock' => $this->stock
                ]
            ]);
        }

        $this->traerMarcas();

        $this->reset(['stock']);

        $this->emit('mensajeGuardarColor');

        //Consulta nuevamente a la base de datos
        //$this->algo = $this->algo->fresh();
        $this->emit('mensajeCreado', "Creado.");
    }


    public function editarPivotModal()
    {
        $this->abierto = true;
        
    }
/*
    public function actualizarPivot()
    {
        $this->validate([
            'pivot_color_id' => 'required',
            'pivot_stock' => 'required',
        ]);

        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->stock = $this->pivot_stock;

        $this->pivot->save();

        $this->medida = $this->medida->fresh();

        $this->reset('abierto');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarVariaMedida(Pivot $variaMedidaId)
    {
        $variaMedidaId->delete();
        $this->medida = $this->medida->fresh();
        $this->emit('mensajeEliminado', "Eliminado.");
    }*/

    public function render()
    {
        return view('livewire.administrador.producto.stock-varia-medida');
    }
}
