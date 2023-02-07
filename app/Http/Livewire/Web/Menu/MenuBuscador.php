<?php

namespace App\Http\Livewire\Web\Menu;

use App\Models\Producto;
use Livewire\Component;

class MenuBuscador extends Component
{
    public $buscar;

    public $abierto = false;

    public function updatedBuscar($value)
    {
        if ($value) {
            $this->abierto = true;
        } else {
            $this->abierto = false;
        }
    }

    public function render()
    {
        if ($this->buscar) {
            $productosBuscador = Producto::where('nombre', 'LIKE', '%' . $this->buscar . '%')
                ->where('estado', 2)
                ->take(8)
                ->get();
        } else {
            $productosBuscador = [];
        }

        return view('livewire.web.menu.menu-buscador', compact('productosBuscador'));
    }
}
