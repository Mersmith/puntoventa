<?php

namespace App\Http\Livewire\Administrador\Cliente;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClienteCrearLivewire extends Component
{
    use WithFileUploads;

    public
        $email = null,
        $password = null,
        $nombre = null,
        $apellido = null,
        $dni = null,
        $ruc = null,
        $celular = null,
        $direccion = null,
        $puntos = 0;

    public $imagen = null;

    protected $rules = [
        'email' => 'required|unique:users',
        'password' => 'required',
    ];

    protected $validationAttributes = [
        'email' => 'email',
        'password' => 'contraseña',
        'nombre' => 'nombre',
        'apellido' => 'apellido',
        'dni' => 'dni',
        'ruc' => 'RUC',
        'celular' => 'celular',
        'direccion' => 'direccion',
        'puntos' => 'puntos',
        'imagen' => 'imagen',
    ];

    protected $messages = [
        'email.required' => 'El :attribute es requerido.',
        'email.unique' => 'El :attribute ya existe.',
        'password.required' => 'La :attribute es requerido.',
        'nombre.required' => 'El :attribute es requerido.',
        'apellido.required' => 'El :attribute es requerido.',
        'dni.required' => 'El :attribute es requerido.',
        'dni.unique' => 'El :attribute ya existe.',
        'ruc.required' => 'El :attribute es requerido.',
        'ruc.unique' => 'El :attribute ya existe.',
        'celular.required' => 'El :attribute es requerido.',
        'direccion.required' => 'La :attribute es requerido.',
        'puntos.required' => 'Los :attribute son requerido.',
        'imagen.required' => 'La :attribute es requerido.',
        'imagen.image' => 'La :attribute debe ser jpg o png.',
        'imagen.max' => 'La :attribute no debe ser mayor de 1024kb',
    ];

    public function crearCliente()
    {
        $rules = $this->rules;

        if ($this->dni) {
            $rules['dni'] = 'required|unique:clientes';
        } else {
            $this->dni = null;
        }

        if ($this->ruc) {
            $rules['ruc'] = 'required|unique:clientes';
        } else {
            $this->ruc = null;
        }

        if ($this->imagen) {
            $rules['imagen'] = 'required|image|max:1024';
            $imagenSubir = $this->imagen->store('clientes');
        }

        $this->validate($rules);

        $usuario = new User();
        $usuario->email = $this->email;
        $usuario->password = Hash::make($this->password);
        $usuario->save();

        $usuario->cliente()->create(
            [
                'email' => $this->email,
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'dni' => $this->dni,
                'ruc' => $this->ruc,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
                'puntos' => $this->puntos,
            ]
        );

        if ($this->imagen) {
            $usuario->cliente->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->emit('mensajeCreado', "Creado.");

        return redirect()->route('administrador.cliente.editar', $usuario);
    }

    public function render()
    {
        return view('livewire.administrador.cliente.cliente-crear-livewire')->layout('layouts.administrador.index');
    }
}
