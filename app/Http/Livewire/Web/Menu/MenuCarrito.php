<?php

namespace App\Http\Livewire\Web\Menu;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class MenuCarrito extends Component
{
    protected $listeners = ['render'];

    public function eliminarProducto($rowId)
    {
        Cart::instance('shopping')->remove($rowId);
    }

    public function render()
    {
        return view('livewire.web.menu.menu-carrito');
    }
}
