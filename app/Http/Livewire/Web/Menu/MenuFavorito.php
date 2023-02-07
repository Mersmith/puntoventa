<?php

namespace App\Http\Livewire\Web\Menu;

use Livewire\Component;

class MenuFavorito extends Component
{
    protected $listeners = ['render'];

    public function render()
    {
        return view('livewire.web.menu.menu-favorito');
    }
}
