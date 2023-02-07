<?php

namespace App\Http\Livewire\Administrador\Producto;

use App\Models\Medida;
use Livewire\Component;
use App\Models\MedidaProducto as Pivot;

class ComponenteVariaMedida extends Component
{
    protected $listeners = ['eliminarPivotMedida'];

    //Crear
    public $producto, $nombre, $medida_id, $stock;

    //Editar
    public $medida, $nombre_editado;
    public $pivot, $pivot_medida_id, $pivot_stock;

    public $abierto = false, $abierto2 = false;

    protected $rules = [
        //'nombre' => 'required'
    ];

    protected $validationAttributes = [
        'nombre' => 'nombre',
        'nombre_editado' => 'medida',
    ];

    protected $messages = [
        'nombre.required' => 'El :attribute es requerido.',
        'nombre_editado.required' => 'La :attribute es requerido.',
    ];

    public function guardarMedida()
    {
        $this->validate();

        $medida = Medida::where('producto_id', $this->producto->id)
            ->where('nombre', $this->nombre)
            ->first();

        if ($medida) {
            $this->emit('mensajeError', 'Existe');
        } else {
            $this->producto->medidas()->create([
                'nombre' => $this->nombre
            ]);
            $this->emit('mensajeCreado', "Creado.");
        }

        $this->reset('nombre');

        $this->producto = $this->producto->fresh();
    }

    public function relacionarMedida()
    {
        // $this->validate();

        $pivot = Pivot::where('medida_id', $this->medida_id)
            ->where('producto_id', $this->producto->id)
            ->first();

        if ($pivot) {
            $pivot->stock = $pivot->stock + $this->stock;
            $pivot->save();
        } else {
            //Atach para registrar un registro en una tabla intermedia
            $this->producto->medida_producto()->attach([
                $this->medida_id => [
                    'stock' => $this->stock
                ]
            ]);
        }

        $this->reset(['medida_id', 'stock']);

        $this->emit('mensajeGuardarColor');

        //Consulta nuevamente a la base de datos
        $this->producto = $this->producto->fresh();
        $this->emit('mensajeCreado', "Creado.");
    }

    public function editarMedida(Medida $medida)
    {
        $this->abierto = true;
        $this->medida = $medida;
        $this->nombre_editado = $medida->nombre;
    }

    public function actualizarMedida()
    {
        $this->validate([
            'nombre_editado' => 'required'
        ]);

        $this->medida->nombre = $this->nombre_editado;
        $this->medida->save();

        $this->producto = $this->producto->fresh();

        $this->abierto = false;
        $this->emit('mensajeEditado', "Actualizado.");
    }

    public function eliminarPivotMedida(Medida $medidaPivotId)
    {
        $medidaPivotId->delete();
        $this->producto = $this->producto->fresh();
    }

    public function editarMedida2(Pivot $pivot)
    {
        $this->abierto2 = true;

        $this->pivot = $pivot;
        $this->pivot_medida_id = $pivot->medida_id;
        $this->pivot_stock = $pivot->stock;
    }

    public function actualizarPivot()
    {
        /*$this->validate([
            'pivot_color_id' => 'required',
            'pivot_stock' => 'required',
        ]);*/

        $this->pivot->medida_id = $this->pivot_medida_id;
        $this->pivot->stock = $this->pivot_stock;

        $this->pivot->save();

        $this->producto = $this->producto->fresh();

        $this->reset('abierto2');
        $this->emit('mensajeActualizado', "Actualizado.");
    }



    public function render()
    {
        $producto_medidas = $this->producto->medidas;
        $producto_medidas_stock = $this->producto->medida_producto;

        return view('livewire.administrador.producto.componente-varia-medida', compact('producto_medidas', 'producto_medidas_stock'));
    }
}
