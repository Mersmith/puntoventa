<?php

namespace App\Http\Livewire\Administrador\Cliente;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ClienteTodoLivewire extends Component
{
    use WithPagination;
    public $buscarCliente;
    protected $paginate = 10;

    public function updatingBuscarCliente()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $this->buscarCliente . '%')
            ->orWhere('email', 'LIKE', '%' . $this->buscarCliente . '%')
            ->paginate(10);

        return view('livewire.administrador.cliente.cliente-todo-livewire', compact('clientes'))->layout('layouts.administrador.index');
    }
}
