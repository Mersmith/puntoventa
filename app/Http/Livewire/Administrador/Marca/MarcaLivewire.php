<?php

namespace App\Http\Livewire\Administrador\Marca;

use App\Models\Imagen;
use Livewire\Component;
use App\Models\Marca;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarcaLivewire extends Component
{
    use WithFileUploads;

    protected $listeners = ['eliminarMarca'];

    public $marcas, $marca;

    public $imagen = null, $imagenSubir = null, $editarImagen = null;

    public $crearFormulario = [
        'nombre' => null,
        'slug' => null,
        'descripcion' => null,
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null,
        'slug' => null,
        'descripcion' => null,
    ];

    public $rules = [
        'crearFormulario.nombre' => 'required|unique:marcas,nombre',
        'crearFormulario.slug' => 'required|unique:marcas,slug',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre',
        'crearFormulario.slug' => 'slug',
        'crearFormulario.descripcion' => 'descripción',

        'editarFormulario.nombre' => 'nombre',
        'editarFormulario.slug' => 'slug',
        'editarFormulario.descripcion' => 'descripción',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.nombre.unique' => 'El :attribute ya existe.',
        'crearFormulario.slug.required' => 'El :attribute es requerido.',
        'crearFormulario.slug.unique' => 'El :attribute ya existe.',
        'crearFormulario.descripcion.required' => 'La :attribute es requerido.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.nombre.unique' => 'El :attribute ya existe.',
        'editarFormulario.slug.required' => 'El :attribute es requerido.',
        'editarFormulario.slug.unique' => 'El :attribute ya existe.',
        'editarFormulario.descripcion.required' => 'La :attribute es requerido.',

        'imagen.required' => 'La :attribute es requerido.',
        'imagen.image' => 'La :attribute debe ser jpg o png.',
        'imagen.max' => 'La :attribute no debe ser mayor de 1024kb',

    ];

    public function traerMarcas()
    {
        $this->marcas = Marca::all();
    }

    public function mount()
    {
        $this->traerMarcas();
    }

    public function updatedCrearFormularioNombre($value)
    {
        $this->crearFormulario['slug'] = Str::slug($value);
    }

    public function updatedEditarFormularioNombre($value)
    {
        $this->editarFormulario['slug'] = Str::slug($value);
    }

    public function crearMarca()
    {
        $rules = $this->rules;

        if ($this->crearFormulario['descripcion']) {
            $rules['crearFormulario.descripcion'] = 'required';
        }

        if ($this->imagenSubir) {
            $rules['imagen'] = 'required|image|max:1024';
            $imagenSubir = $this->imagenSubir->store('marcas');
        }

        $this->validate($rules);

        $marcaNuevo = Marca::create($this->crearFormulario);

        if ($this->imagenSubir) {
            $marcaNuevo->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->traerMarcas();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario', 'imagen');
    }


    public function editarMarca(Marca $marca)
    {
        $this->resetValidation();

        $this->marca = $marca;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $marca->nombre;
        $this->editarFormulario['slug'] = $marca->slug;
        $this->editarFormulario['descripcion'] = $marca->descripcion;
        $this->imagen = $marca->imagen ? $marca->imagen->imagen_ruta : null;
    }

    public function actualizarMarca()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:marcas,nombre,' . $this->marca->id,
            'editarFormulario.slug' => 'required|unique:marcas,slug,' . $this->marca->id,
        ];

        if ($this->editarFormulario['descripcion']) {
            $rules['editarFormulario.descripcion'] = 'required';
        } else {
            $this->editarFormulario['descripcion'] = null;
        }

        if ($this->editarImagen) {
            $rules['editarImagen'] = 'required|image|max:1024';
            $imagenSubir = $this->editarImagen->store('marcas');
        }

        $this->validate($rules);

        $this->marca->update($this->editarFormulario);

        if (!$this->imagen) {
            if ($this->marca->imagen) {
                $imagenEliminar = $this->marca->imagen;
                Storage::delete([$this->marca->imagen->imagen_ruta]);

                $imagenEliminar->delete();
            }
        }

        if ($this->editarImagen) {
            if ($this->marca->imagen) {
                $imagenAntigua = $this->marca->imagen;
                Storage::delete([$this->marca->imagen->imagen_ruta]);

                $imagenAntigua->delete();
            }

            $this->marca->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->traerMarcas();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarMarca(Marca $marca)
    {
        if ($marca->imagen) {
            $imagenEliminar = $marca->imagen;

            Storage::delete([$marca->imagen->imagen_ruta]);
            $imagenEliminar->delete();
        }

        $marca->delete();
        $this->traerMarcas();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.marca.marca-livewire')->layout('layouts.administrador.index');
    }
}
