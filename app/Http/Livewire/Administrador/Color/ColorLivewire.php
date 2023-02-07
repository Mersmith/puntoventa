<?php

namespace App\Http\Livewire\Administrador\Color;

use App\Models\Color;
use Livewire\Component;

class ColorLivewire extends Component
{
    public $colores, $color;

    protected $listeners = ['eliminarColor'];

    public $crearFormulario = [
        'nombre' => null,
        'codigo' => null,
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null,
        'codigo' => null,
    ];

    protected $rules = [
        'crearFormulario.nombre' => 'required|unique:colors,nombre',
        'crearFormulario.codigo' => 'required|unique:colors,codigo',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre',
        'crearFormulario.codigo' => 'código',

        'editarFormulario.nombre' => 'nombre',
        'editarFormulario.codigo' => 'código',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.nombre.unique' => 'El :attribute ya existe.',
        'crearFormulario.codigo.required' => 'El :attribute es requerido.',
        'crearFormulario.codigo.unique' => 'El :attribute ya existe.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.nombre.unique' => 'El :attribute ya existe.',
        'editarFormulario.codigo.required' => 'El :attribute es requerido.',
        'editarFormulario.codigo.unique' => 'El :attribute ya existe.',
    ];

    public function traerColores()
    {
        $this->colores = Color::all();
    }

    public function mount()
    {
        $this->traerColores();
    }

    public function crearColor()
    {
        $this->validate();

        Color::create($this->crearFormulario);

        $this->traerColores();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario');
    }

    public function editarColor(Color $color)
    {
        $this->resetValidation();

        $this->color = $color;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $color->nombre;
        $this->editarFormulario['codigo'] = $color->codigo;
    }

    public function actualizarColor()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:colors,nombre,' . $this->color->id,
            'editarFormulario.codigo' => 'required|unique:colors,codigo,' . $this->color->id,
        ];

        $this->validate($rules);

        $this->color->update($this->editarFormulario);

        $this->traerColores();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }


    public function eliminarColor(Color $color)
    {
        $color->delete();
        $this->traerColores();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.color.color-livewire')->layout('layouts.administrador.index');
    }
}
