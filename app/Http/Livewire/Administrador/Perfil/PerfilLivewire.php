<?php

namespace App\Http\Livewire\Administrador\Perfil;

use App\Models\Administrador;
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

    public $administrador;

    public
        $email = null,
        $nombre = null,
        $apellido  = null,
        $celular = null;

    public $imagen;
    public $editarImagen = null;

    protected $rules = [];

    protected $validationAttributes = [
        'email' => 'email',
        'nombre' => 'nombre',
        'apellido' => 'apellido',
        'celular' => 'celular',
        'editarImagen' => 'editarImagen',
    ];

    protected $messages = [
        'nombre.required' => 'El :attribute es requerido.',
        'apellido.required' => 'El :attribute es requerido.',
        'celular.required' => 'El :attribute es requerido.',
        'editarImagen.required' => 'La :attribute es requerido.',
        'editarImagen.image' => 'La :attribute debe ser jpg o png.',
        'editarImagen.max' => 'La :attribute no debe ser mayor de 1024kb',
    ];

    public function mount()
    {
        $usuario = Auth()->user();
        $this->email = Auth()->user()->email;

        if ($usuario->administrador) {
            $this->administrador = $usuario->administrador;
            $this->nombre = $this->administrador->nombre;
            $this->apellido = $this->administrador->apellido;
            $this->celular = $this->administrador->celular;
            $this->imagen = $this->administrador->imagen ? $this->administrador->imagen->imagen_ruta : null;
        } else {
            $usuario->administrador()->create(
                [
                    'email' => $this->email,
                ]
            );
        }
    }

    public function editarAdministrador()
    {
        $rules = $this->rules;
       
        if ($this->editarImagen) {
            $rules['editarImagen'] = 'required|image|max:1024';
            $imagenSubir = $this->editarImagen->store('administradores');
        }

        if (count($rules) > 0) {
            $this->validate($rules);
        }

        $this->administrador->update(
            [
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'celular' => $this->celular,
            ]
        );

        if (!$this->imagen) {
            if ($this->administrador->imagen) {
                $imagenEliminar = $this->administrador->imagen;
                Storage::delete([$this->administrador->imagen->imagen_ruta]);

                $imagenEliminar->delete();
            }
        }

        if ($this->editarImagen) {
            if ($this->administrador->imagen) {
                $imagenAntigua = $this->administrador->imagen;
                Storage::delete([$this->administrador->imagen->imagen_ruta]);

                $imagenAntigua->delete();
            }

            $this->administrador->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->emit('mensajeActualizado', "Editado.");

        //return redirect()->route('administrador.administrador.index');
    }

    public function render()
    {
        return view('livewire.administrador.perfil.perfil-livewire')->layout('layouts.administrador.index');
    }
}
