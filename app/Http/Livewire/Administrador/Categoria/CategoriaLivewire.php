<?php

namespace App\Http\Livewire\Administrador\Categoria;

use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class CategoriaLivewire extends Component
{
    use WithFileUploads;

    public $categorias, $categoria;

    public $marcas;

    public $imagen = null, $imagenSubir = null, $editarImagen = null;

    protected $listeners = ['eliminarCategoria'];

    public $crearFormulario = [
        'nombre' => null,
        'slug' => null,
        'icono' => null,
        'descripcion' => null,
        'marcas' => [],
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null,
        'slug' => null,
        'icono' => null,
        'descripcion' => null,
        'marcas' => [],
    ];

    protected $rules = [
        'crearFormulario.nombre' => 'required|unique:categorias,nombre',
        'crearFormulario.slug' => 'required|unique:categorias,slug',
        'crearFormulario.marcas' => 'required',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre',
        'crearFormulario.slug' => 'slug',
        'crearFormulario.icono' => 'icono',
        'crearFormulario.descripcion' => 'descripción',
        'crearFormulario.marcas' => 'marcas de categoria',

        'editarFormulario.nombre' => 'nombre',
        'editarFormulario.slug' => 'slug',
        'editarFormulario.icono' => 'icono',
        'editarFormulario.descripcion' => 'descripción',
        'editarFormulario.marcas' => 'marcas de categoria',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.nombre.unique' => 'El :attribute ya existe.',
        'crearFormulario.slug.required' => 'El :attribute es requerido.',
        'crearFormulario.slug.unique' => 'El :attribute ya existe.',
        'crearFormulario.icono.required' => 'El :attribute es requerido.',
        'crearFormulario.descripcion.required' => 'La :attribute es requerido.',
        'crearFormulario.marcas.required' => 'La :attribute es requerido.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.nombre.unique' => 'El :attribute ya existe.',
        'editarFormulario.slug.required' => 'El :attribute es requerido.',
        'editarFormulario.slug.unique' => 'El :attribute ya existe.',
        'editarFormulario.icono.required' => 'El :attribute es requerido.',
        'editarFormulario.descripcion.required' => 'La :attribute es requerido.',
        'editarFormulario.marcas.required' => 'La :attribute es requerido.',
    ];

    public function traerCategorias()
    {
        $this->categorias = Categoria::all();
    }

    public function traerMarcas()
    {
        $this->marcas = Marca::all();
    }

    public function mount()
    {
        $this->traerCategorias();
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

    public function crearCategoria()
    {
        $rules = $this->rules;

        if ($this->crearFormulario['descripcion']) {
            $rules['crearFormulario.descripcion'] = 'required';
        }

        if ($this->imagenSubir) {
            $rules['imagen'] = 'required|image|max:1024';
            $imagenSubir = $this->imagenSubir->store('categorias');
        }

        $this->validate($rules);

        $categoriaNuevo = Categoria::create($this->crearFormulario);

        $categoriaNuevo->marcas()->attach($this->crearFormulario['marcas']);

        if ($this->imagenSubir) {
            $categoriaNuevo->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->traerCategorias();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario', 'imagen');
    }

    public function editarCategoria(Categoria $categoria)
    {
        $this->resetValidation();

        $this->categoria = $categoria;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $categoria->nombre;
        $this->editarFormulario['slug'] = $categoria->slug;
        $this->editarFormulario['icono'] = $categoria->icono;
        $this->editarFormulario['descripcion'] = $categoria->descripcion;
        $this->editarFormulario['marcas'] = $categoria->marcas->pluck('id');
        $this->imagen = $categoria->imagen ? $categoria->imagen->imagen_ruta : null;
    }

    public function actualizarCategoria()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:categorias,nombre,' . $this->categoria->id,
            'editarFormulario.slug' => 'required|unique:categorias,slug,' . $this->categoria->id,
            'editarFormulario.marcas' => 'required',
        ];

        if ($this->editarFormulario['descripcion']) {
            $rules['editarFormulario.descripcion'] = 'required';
        } else {
            $this->editarFormulario['descripcion'] = null;
        }

        if ($this->editarImagen) {
            $rules['editarImagen'] = 'required|image|max:1024';
            $imagenSubir = $this->editarImagen->store('categorias');
        }

        $this->validate($rules);

        $this->categoria->update($this->editarFormulario);
        $this->categoria->marcas()->sync($this->editarFormulario['marcas']);

        if (!$this->imagen) {
            if ($this->categoria->imagen) {
                $imagenEliminar = $this->categoria->imagen;
                Storage::delete([$this->categoria->imagen->imagen_ruta]);

                $imagenEliminar->delete();
            }
        }

        if ($this->editarImagen) {
            if ($this->categoria->imagen) {
                $imagenAntigua = $this->categoria->imagen;
                Storage::delete([$this->categoria->imagen->imagen_ruta]);

                $imagenAntigua->delete();
            }

            $this->categoria->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->traerCategorias();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarCategoria(Categoria $categoria)
    {
        if ($categoria->imagen) {
            $imagenEliminar = $categoria->imagen;

            Storage::delete([$categoria->imagen->imagen_ruta]);
            $imagenEliminar->delete();
        }

        $categoria->delete();
        $this->traerCategorias();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.categoria.categoria-livewire')->layout('layouts.administrador.index');
    }
}
