<?php

namespace App\Http\Livewire\Administrador\Compra;

use App\Models\Compra;
use Livewire\Component;
use Livewire\WithPagination;

class CompraTodoLivewire extends Component
{
    use WithPagination;
    public $buscarCompra;
    protected $paginate = 10;

    public function updatingBuscarCompra()
    {
        $this->resetPage();
    }

    public function render()
    {
        $compras = Compra::paginate(10);

        return view('livewire.administrador.compra.compra-todo-livewire', compact('compras'))->layout('layouts.administrador.index');
    }
}
