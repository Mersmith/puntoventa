<?php

namespace App\Http\Livewire\Administrador\Subcategoria;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Livewire\Component;
use Illuminate\Support\Str;

class SubcategoriaLivewire extends Component
{
    public $categoria, $subcategorias, $subcategoria;

    protected $listeners = ['eliminarSubcategoria'];

    public $crearFormulario = [
        'nombre' => null,
        'slug' => null,
        'icono' => null,
        'descripcion' => null,
        'tiene_color' => false,
        'tiene_medida' => false
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null,
        'slug' => null,
        'icono' => null,
        'descripcion' => null,
        'tiene_color' => false,
        'tiene_medida' => false
    ];

    protected $rules = [
        'crearFormulario.nombre' => 'required|unique:subcategorias,nombre',
        'crearFormulario.slug' => 'required|unique:subcategorias,slug',
        'crearFormulario.tiene_color' => 'required',
        'crearFormulario.tiene_medida' => 'required',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre de la subcategoria',
        'crearFormulario.slug' => 'slug nombre de la subcategoria',
        'crearFormulario.icono' => 'icono',
        'crearFormulario.descripcion' => 'descripción',

        'editarFormulario.nombre' => 'nombre de la subcategoria',
        'editarFormulario.slug' => 'slug nombre de la subcategoria',
        'editarFormulario.icono' => 'icono',
        'editarFormulario.descripcion' => 'descripción',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.slug.required' => 'El :attribute  requerido.',
        'crearFormulario.icono.required' => 'El :attribute es requerido.',
        'crearFormulario.descripcion.required' => 'La :attribute es requerido.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.slug.required' => 'El :attribute  requerido.',
        'editarFormulario.icono.required' => 'El :attribute es requerido.',
        'editarFormulario.descripcion.required' => 'La :attribute es requerido.',
    ];

    public function mount(Categoria $categoria)
    {
        $this->categoria = $categoria;
        $this->traerSubcategorias();
    }

    public function traerSubcategorias()
    {
        $this->subcategorias = Subcategoria::where('categoria_id', $this->categoria->id)->get();
    }

    public function updatedCrearFormularioNombre($value)
    {
        $this->crearFormulario['slug'] = Str::slug($value);
    }

    public function updatedEditarFormularioNombre($value)
    {
        $this->editarFormulario['slug'] = Str::slug($value);
    }

    public function crearSubcategoria()
    {
        $this->validate();

        $this->categoria->subcategorias()->create($this->crearFormulario);
        $this->traerSubcategorias();

        $this->emit('mensajeCreado', "Agregada.");
        $this->reset('crearFormulario');
    }

    public function editarSubcategoria(Subcategoria $subcategoria)
    {
        $this->resetValidation();

        $this->subcategoria = $subcategoria;

        $this->editarFormulario['abierto'] = true;

        $this->editarFormulario['nombre'] = $subcategoria->nombre;
        $this->editarFormulario['slug'] = $subcategoria->slug;
        $this->editarFormulario['icono'] = $subcategoria->icono;
        $this->editarFormulario['descripcion'] = $subcategoria->descripcion;
        $this->editarFormulario['tiene_color'] = $subcategoria->tiene_color;
        $this->editarFormulario['tiene_medida'] = $subcategoria->tiene_medida;
    }

    public function actualizarSubcategoria()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:subcategorias,nombre,' . $this->subcategoria->id,
            'editarFormulario.slug' => 'required|unique:subcategorias,slug,' . $this->subcategoria->id,
            'editarFormulario.tiene_color' => 'required',
            'editarFormulario.tiene_medida' => 'required',
        ];
        
        if ($this->editarFormulario['descripcion']) {
            $rules['editarFormulario.descripcion'] = 'required';
        } else {
            $this->editarFormulario['descripcion'] = null;
        }

        $this->validate($rules);

        $this->subcategoria->update($this->editarFormulario);

        $this->traerSubcategorias();
        $this->reset('editarFormulario');

        $this->emit('mensajeActualizado', "Actualizada.");
    }

    public function eliminarSubcategoria(Subcategoria $subcategoria)
    {
        $subcategoria->delete();
        $this->traerSubcategorias();
    }

    public function render()
    {
        return view('livewire.administrador.subcategoria.subcategoria-livewire')->layout('layouts.administrador.index');
    }
}
