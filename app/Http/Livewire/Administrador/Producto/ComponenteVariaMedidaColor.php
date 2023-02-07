<?php

namespace App\Http\Livewire\Administrador\Producto;

use Livewire\Component;
use App\Models\Medida;

class ComponenteVariaMedidaColor extends Component
{
    protected $listeners = ['eliminarPivotMedidaColor'];

    //Crear
    public $producto, $nombre;

    //Editar
    public $medida, $nombre_editado;

    public $abierto = false;

    protected $rules = [
        'nombre' => 'required'
    ];

    protected $validationAttributes = [
        'nombre' => 'nombre',
        'nombre_editado' => 'nombre',
    ];

    protected $messages = [
        'nombre.required' => 'El :attribute es requerido.',
        'nombre_editado.required' => 'El :attribute es requerido.',
    ];

    public function guardarMedida()
    {
        $this->validate();

        $medida = Medida::where('producto_id', $this->producto->id)
            ->where('nombre', $this->nombre)
            ->first();

        if ($medida) {
            $this->emit('mensajeError', 'Existe.');
        } else {
            $this->producto->medidas()->create([
                'nombre' => $this->nombre
            ]);
            $this->emit('mensajeCreado', "Creado.");
        }

        $this->reset('nombre');

        $this->producto = $this->producto->fresh();
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

    public function eliminarPivotMedidaColor(Medida $medidaColorPivotId)
    {
        $medidaColorPivotId->delete();
        $this->producto = $this->producto->fresh();
    }

    public function render()
    {
        $producto_medidas = $this->producto->medidas;

        return view('livewire.administrador.producto.componente-varia-medida-color', compact('producto_medidas'));
    }
}
