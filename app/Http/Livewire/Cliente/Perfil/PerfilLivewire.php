<?php

namespace App\Http\Livewire\Cliente\Perfil;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Imagen;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class PerfilLivewire extends Component
{
    use WithFileUploads;

    public $cliente;

    public
        $email = null,
        $password = "contrasenaejemplo",
        $editarPassword = null,
        $nombre = null,
        $apellido  = null,
        $dni = null,
        $ruc = null,
        $celular = null,
        $direccion = null,
        $puntos = null;

    public $imagen;
    public $editarImagen = null;

    protected $rules = [];

    protected $validationAttributes = [
        'email' => 'email',
        'editarPassword' => 'contraseña',
        'nombre' => 'nombre',
        'apellido' => 'apellido',
        'dni' => 'dni',
        'ruc' => 'RUC',
        'celular' => 'celular',
        'direccion' => 'direccion',
        'puntos' => 'puntos',
        'editarImagen' => 'editarImagen',
    ];

    protected $messages = [
        'email.required' => 'El :attribute es requerido.',
        'email.unique' => 'El :attribute ya existe.',
        'editarPassword.required' => 'La :attribute es requerido.',
        'nombre.required' => 'El :attribute es requerido.',
        'apellido.required' => 'El :attribute es requerido.',
        'dni.required' => 'El :attribute es requerido.',
        'dni.unique' => 'El :attribute ya existe.',
        'ruc.required' => 'El :attribute es requerido.',
        'ruc.unique' => 'El :attribute ya existe.',
        'celular.required' => 'El :attribute es requerido.',
        'direccion.required' => 'La :attribute es requerido.',
        'puntos.required' => 'Los :attribute son requerido.',
        'editarImagen.required' => 'La :attribute es requerido.',
        'editarImagen.image' => 'La :attribute debe ser jpg o png.',
        'editarImagen.max' => 'La :attribute no debe ser mayor de 1024kb',
    ];

    public function mount()
    {
        $usuario = Auth()->user();
        $this->email = Auth()->user()->email;

        if ($usuario->cliente) {
            $this->cliente = $usuario->cliente;
            $this->nombre = $this->cliente->nombre;
            $this->apellido = $this->cliente->apellido;
            $this->dni = $this->cliente->dni;
            $this->ruc = $this->cliente->ruc;
            $this->celular = $this->cliente->celular;
            $this->direccion = $this->cliente->direccion;
            $this->puntos = $this->cliente->puntos;
            $this->imagen = $this->cliente->imagen ? $this->cliente->imagen->imagen_ruta : null;
        } else {
            $usuario->cliente()->create(
                [
                    'email' => $this->email,
                ]
            );
        }
    }

    public function editarCliente()
    {
        $rules = $this->rules;

        if ($this->dni) {
            $rules['dni'] = 'required|unique:clientes,dni,' . $this->cliente->id;
        } else {
            $this->dni = null;
        }

        if ($this->ruc) {
            $rules['ruc'] = 'required|unique:clientes,ruc,' . $this->cliente->id;
        } else {
            $this->ruc = null;
        }

        if ($this->editarImagen) {
            $rules['editarImagen'] = 'required|image|max:1024';
            $imagenSubir = $this->editarImagen->store('clientes');
        }

        if ($this->editarPassword) {
            $rules['editarPassword'] = 'required';
        } else {
            $this->editarPassword = null;
        }

        if (count($rules) > 0) {
            $this->validate($rules);
        }

        $this->cliente->update(
            [
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'dni' => $this->dni,
                'ruc' => $this->ruc,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
            ]
        );

        if ($this->editarPassword) {
            $usuario = User::find($this->cliente->user_id);

            //$contrasenaAntiguaHash = $usuario->password;
            $contrasenaNueva = $this->editarPassword;

            $usuario->password = Hash::make($contrasenaNueva);
            $usuario->save();
        }

        if (!$this->imagen) {
            if ($this->cliente->imagen) {
                $imagenEliminar = $this->cliente->imagen;
                Storage::delete([$this->cliente->imagen->imagen_ruta]);

                $imagenEliminar->delete();
            }
        }

        if ($this->editarImagen) {
            if ($this->cliente->imagen) {
                $imagenAntigua = $this->cliente->imagen;
                Storage::delete([$this->cliente->imagen->imagen_ruta]);

                $imagenAntigua->delete();
            }

            $this->cliente->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->emit('mensajeActualizado', "Editado.");

        //return redirect()->route('administrador.cliente.index');
    }

    public function render()
    {
        return view('livewire.cliente.perfil.perfil-livewire')->layout('layouts.cliente.index');
    }
}
