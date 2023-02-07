<?php

namespace App\Http\Livewire\Administrador\Impresora;

use App\Models\Impresora;
use Livewire\Component;

class ImpresoraLivewire extends Component
{
    public $impresoras, $impresora;

    protected $listeners = ['eliminarImpresora'];

    public $crearFormulario = [
        'nombre' => null
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null
    ];

    protected $rules = [
        'crearFormulario.nombre' => 'required|unique:impresoras,nombre',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre',

        'editarFormulario.nombre' => 'nombre',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.nombre.unique' => 'El :attribute ya existe.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.nombre.unique' => 'El :attribute  ya existe.',
    ];


    public function traerImpresoras()
    {
        $this->impresoras = Impresora::all();
    }

    public function mount()
    {
        $this->traerImpresoras();
    }

    public function crearImpresora()
    {
        $this->validate();

        Impresora::create($this->crearFormulario);

        $this->traerImpresoras();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario');
    }

    public function editarImpresora(Impresora $impresora)
    {
        $this->resetValidation();

        $this->impresora = $impresora;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $impresora->nombre;
    }

    public function actualizarImpresora()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:impresoras,nombre,' . $this->impresora->id,
        ];

        $this->validate($rules);

        $this->impresora->update($this->editarFormulario);

        $this->traerImpresoras();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarImpresora(Impresora $impresora)
    {
        $impresora->delete();
        $this->traerImpresoras();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.impresora.impresora-livewire')->layout('layouts.administrador.index');
    }
}
