<?php

namespace App\Http\Livewire\Administrador\Slider;

use App\Models\Imagen;
use App\Models\Slider;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SliderLivewire extends Component
{
    use WithFileUploads;

    public $sliders, $slider;

    public $editarImagen = null;

    protected $listeners = ['eliminarSlider'];

    public $crearFormulario = [
        'link' => null,
        'estado' => true,
        'imagen' => null,
    ];

    public $editarFormulario = [
        'abierto' => false,
        'link' => null,
        'estado' => null,
        'imagen' => null,
    ];

    protected $rules = [
        'crearFormulario.estado' => 'required',
        'crearFormulario.imagen' => 'required|image|max:1024',
    ];

    protected $validationAttributes = [
        'crearFormulario.link' => 'link',
        'crearFormulario.estado' => 'estado',
        'crearFormulario.imagen' => 'imagen',

        'editarFormulario.link' => 'nombre',
        'editarFormulario.estado' => 'slug',
        'editarFormulario.imagen' => 'imagen',

        'editarImagen' => 'imagen',
    ];

    protected $messages = [
        'crearFormulario.link.required' => 'El :attribute es requerido.',
        'crearFormulario.estado.required' => 'El :attribute es requerido.',
        'crearFormulario.imagen.required' => 'La :attribute es requerido.',
        'crearFormulario.imagen.image' => 'La :attribute debe ser jpg o png.',
        'crearFormulario.imagen.max' => 'La :attribute no debe ser mayor de 1024kb',

        'editarFormulario.link.required' => 'El :attribute es requerido.',
        'editarFormulario.estado.required' => 'El :attribute es requerido.',
        'editarFormulario.imagen.required' => 'La :attribute es requerido.',
        'editarFormulario.imagen.image' => 'La :attribute debe ser jpg o png.',
        'editarFormulario.imagen.max' => 'La :attribute no debe ser mayor de 1024kb',

        'editarImagen.required' => 'La :attribute es requerido.',
        'editarImagen.image' => 'La :attribute debe ser jpg o png.',
        'editarImagen.max' => 'La :attribute no debe ser mayor de 1024kb',

    ];

    public function traerSliders()
    {
        $this->sliders = Slider::orderBy('posicion', 'asc')->get();
    }

    public function mount()
    {
        $this->traerSliders();
    }

    public function crearSlider()
    {
        $rules = $this->rules;

        if ($this->crearFormulario['link']) {
            $rules['crearFormulario.link'] = 'required';
        }

        $this->validate($rules);

        $imagenSubir = $this->crearFormulario['imagen']->store('sliders');

        $slider = Slider::create([
            'link' => $this->crearFormulario['link'],
            'estado' => $this->crearFormulario['estado'],
            'posicion' => $this->sliders->count() + 1
        ]);

        $slider->imagen()->create([
            'imagen_ruta' => $imagenSubir
        ]);

        $this->traerSliders();

        $this->emit('mensajeCreado', "Creado");
        $this->reset('crearFormulario');
    }

    public function editarSlider(Slider $slider)
    {
        $this->resetValidation();

        $this->slider = $slider;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['link'] = $slider->link;
        $this->editarFormulario['estado'] = $slider->estado;
        $this->editarFormulario['imagen'] = $slider->imagen ? $slider->imagen->imagen_ruta : null;
    }

    public function actualizarSlider()
    {
        $rules = [];

        if ($this->editarFormulario['link']) {
            $rules['editarFormulario.link'] = 'required';
        } else {
            $this->editarFormulario['link'] = null;
        }

        if ($this->editarImagen) {
            $rules['editarImagen'] = 'required|image|max:1024';
            $imagenSubir = $this->editarImagen->store('sliders');
        }
        
        if (count($rules) > 0) {
            $this->validate($rules);
        }

        $this->slider->update($this->editarFormulario);

        if (!$this->editarFormulario['imagen']) {
            if ($this->slider->imagen) {
                $imagenEliminar = $this->slider->imagen;
                Storage::delete([$this->slider->imagen->imagen_ruta]);

                $imagenEliminar->delete();
            }
        }

        if ($this->editarImagen) {
            if ($this->slider->imagen) {
                $imagenAntigua = $this->slider->imagen;
                Storage::delete([$this->slider->imagen->imagen_ruta]);

                $imagenAntigua->delete();
            }

            $this->slider->imagen()->create([
                'imagen_ruta' => $imagenSubir
            ]);
        }

        $this->traerSliders();
        $this->reset('editarFormulario', 'editarImagen');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarSlider(Slider $slider)
    {
        if ($slider->imagen) {
            $imagenEliminar = $slider->imagen;

            Storage::delete([$slider->imagen->imagen_ruta]);
            $imagenEliminar->delete();
        }

        $slider->delete();
        $this->traerSliders();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.slider.slider-livewire')->layout('layouts.administrador.index');
    }
}
