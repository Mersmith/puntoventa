<?php

namespace App\Http\Livewire\Administrador\Tag;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Str;

class TagLivewire extends Component
{
    public $tags, $tag;

    protected $listeners = ['eliminarTag'];

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
        'crearFormulario.nombre' => 'required|unique:tags,nombre',
        'crearFormulario.slug' => 'required|unique:tags,slug',
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
    ];

    public function traerTags()
    {
        $this->tags = Tag::all();
    }

    public function mount()
    {
        $this->traerTags();
    }

    public function updatedCrearFormularioNombre($value)
    {
        $this->crearFormulario['slug'] = Str::slug($value);
    }

    public function updatedEditarFormularioNombre($value)
    {
        $this->editarFormulario['slug'] = Str::slug($value);
    }

    public function crearTag()
    {
        $rules = $this->rules;

        if ($this->crearFormulario['descripcion']) {
            $rules['crearFormulario.descripcion'] = 'required';
        }

        $this->validate($rules);

        Tag::create($this->crearFormulario);

        $this->traerTags();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario');
    }

    public function editarTag(Tag $tag)
    {
        $this->resetValidation();

        $this->tag = $tag;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $tag->nombre;
        $this->editarFormulario['slug'] = $tag->slug;
        $this->editarFormulario['descripcion'] = $tag->descripcion;
    }

    public function actualizarTag()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:tags,nombre,' . $this->tag->id,
            'editarFormulario.slug' => 'required|unique:tags,slug,' . $this->tag->id,
        ];

        if ($this->editarFormulario['descripcion']) {
            $rules['editarFormulario.descripcion'] = 'required';
        } else {
            $this->editarFormulario['descripcion'] = null;
        }

        $this->validate($rules);

        $this->tag->update($this->editarFormulario);

        $this->traerTags();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarTag(Tag $tag)
    {
        $tag->delete();
        $this->traerTags();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.tag.tag-livewire')->layout('layouts.administrador.index');
    }
}
