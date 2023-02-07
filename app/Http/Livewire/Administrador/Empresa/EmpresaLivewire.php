<?php

namespace App\Http\Livewire\Administrador\Empresa;

use App\Models\Empresa;
use Livewire\Component;

class EmpresaLivewire extends Component
{
    public $empresa;

    public $editarFormulario = [
        'nombre' => null,
        'descripcion' => null,
        'email' => null,
        'direccion' => null,
        'ruc' => null,
    ];

    protected $rules = [
        'editarFormulario.nombre' => 'required',
    ];

    protected $validationAttributes = [
        'editarFormulario.nombre' => 'nombre',
    ];

    protected $messages = [
        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
    ];



    public function mount()
    {
        $empresa = Empresa::where('id', 1)->get();

        $this->empresa = $empresa->first();

        if ($this->empresa) {

            $this->editarFormulario['nombre'] = $this->empresa->nombre;
            $this->editarFormulario['descripcion'] = $this->empresa->descripcion;
            $this->editarFormulario['email'] = $this->empresa->email;
            $this->editarFormulario['direccion'] = $this->empresa->direccion;
            $this->editarFormulario['ruc'] = $this->empresa->ruc;
        }
    }

    public function actualizarEmpresa()
    {
        $this->validate();

        if ($this->empresa) {

            $this->empresa->update($this->editarFormulario);

            $this->emit('mensajeActualizado', "Actualizado.");
        } else {
            Empresa::create($this->editarFormulario);

            $this->emit('mensajeActualizado', "Actualizado.");
        }
    }

    public function render()
    {
        return view('livewire.administrador.empresa.empresa-livewire')->layout('layouts.administrador.index');
    }
}
