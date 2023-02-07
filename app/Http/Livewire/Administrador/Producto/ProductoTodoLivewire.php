<?php

namespace App\Http\Livewire\Administrador\Producto;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class ProductoTodoLivewire extends Component
{
    use WithPagination;
    public $buscarProducto;
    protected $paginate = 50;

    public function updatingBuscarProducto()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $productos = Producto::where('nombre', 'like', '%' . $this->buscarProducto . '%')->paginate(50);

        return view('livewire.administrador.producto.producto-todo-livewire', compact('productos'))->layout('layouts.administrador.index');
    }
}
