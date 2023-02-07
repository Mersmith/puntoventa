<?php

namespace App\Http\Livewire\Administrador\Reporte;

use App\Models\Compra;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CompraDiaLivewire extends Component
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
        $compras = Compra::whereDate('created_at', Carbon::today())->paginate(10);

        return view('livewire.administrador.reporte.compra-dia-livewire', compact('compras'))->layout('layouts.administrador.index');
    }
}
