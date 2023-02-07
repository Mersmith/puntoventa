<?php

namespace App\Http\Livewire\Administrador\Proveedor;

use App\Models\Proveedor;
use Livewire\Component;

class ProveedorLivewire extends Component
{
    public $proveedores, $proveedor;

    protected $listeners = ['eliminarProveedor'];

    public $crearFormulario = [
        'nombre' => null,
        'email' => null,
        'ruc' => null,
        'direccion' => null,
        'celular' => null,
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null,
        'email' => null,
        'ruc' => null,
        'direccion' => null,
        'celular' => null,
    ];

    protected $rules = [
        'crearFormulario.nombre' => 'required',
        'crearFormulario.email' => 'required|unique:proveedors,email',
        'crearFormulario.ruc' => 'required|unique:proveedors,ruc',
        'crearFormulario.direccion' => 'required',
        'crearFormulario.celular' => 'required',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre',
        'crearFormulario.email' => 'email',
        'crearFormulario.ruc' => 'ruc',
        'crearFormulario.direccion' => 'dirección',
        'crearFormulario.celular' => 'celular',

        'editarFormulario.nombre' => 'nombre',
        'editarFormulario.email' => 'email',
        'editarFormulario.ruc' => 'ruc',
        'editarFormulario.direccion' => 'dirección',
        'editarFormulario.celular' => 'celular',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.email.required' => 'El :attribute es requerido.',
        'crearFormulario.email.unique' => 'El :attribute ya existe.',
        'crearFormulario.ruc.required' => 'El :attribute es requerido.',
        'crearFormulario.ruc.unique' => 'El :attribute ya existe.',
        'crearFormulario.direccion.required' => 'La :attribute es requerido.',
        'crearFormulario.celular.required' => 'El :attribute es requerido.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.email.required' => 'El :attribute es requerido.',
        'editarFormulario.email.unique' => 'El :attribute ya existe.',
        'editarFormulario.ruc.required' => 'El :attribute es requerido.',
        'editarFormulario.ruc.unique' => 'El :attribute ya existe.',
        'editarFormulario.direccion.required' => 'La :attribute es requerido.',
        'editarFormulario.celular.required' => 'El :attribute es requerido.',
    ];

    public function traerProveedores()
    {
        $this->proveedores = Proveedor::all();
    }

    public function mount()
    {
        $this->traerProveedores();
    }

    public function crearProveedor()
    {
        $this->validate();

        Proveedor::create($this->crearFormulario);

        $this->traerProveedores();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario');
    }

    public function editarProveedor(Proveedor $proveedor)
    {
        $this->resetValidation();

        $this->proveedor = $proveedor;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $proveedor->nombre;
        $this->editarFormulario['email'] = $proveedor->email;
        $this->editarFormulario['ruc'] = $proveedor->ruc;
        $this->editarFormulario['direccion'] = $proveedor->direccion;
        $this->editarFormulario['celular'] = $proveedor->celular;
    }

    public function actualizarProveedor()
    {
        $rules = [
            'editarFormulario.nombre' => 'required',
            'editarFormulario.email' => 'required|unique:proveedors,email,'. $this->proveedor->id,
            'editarFormulario.ruc' => 'required|unique:proveedors,ruc,'. $this->proveedor->id,
            'editarFormulario.direccion' => 'required',
            'editarFormulario.celular' => 'required',
        ];

        $this->validate($rules);

        $this->proveedor->update($this->editarFormulario);

        $this->traerProveedores();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarProveedor(Proveedor $proveedor)
    {
        $proveedor->delete();        
        $this->traerProveedores();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.proveedor.proveedor-livewire')->layout('layouts.administrador.index');
    }
}
