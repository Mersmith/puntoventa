<?php

namespace App\Http\Livewire\Administrador\Reporte;

use App\Models\Compra;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CompraFechaLivewire extends Component
{
    use WithPagination;
    public $buscarCompra;
    protected $paginate = 10;

    public $fecha_inicial, $fecha_final;

    public function updatingBuscarCompra()
    {
        $this->resetPage();
    }

    public function buscarFecha()
    {
        $this->resetPage();
    }

    public function render()
    {
        $comprasQuery = Compra::query();

        if ($this->fecha_inicial && $this->fecha_final) {
            $fecha_completa_inicial = $this->fecha_inicial . ' 00:00:00';
            $fecha_completa_final = $this->fecha_final . ' 23:59:59';

            $compras = $comprasQuery->whereBetween('created_at', [$fecha_completa_inicial, $fecha_completa_final])->orderBy('created_at', 'desc')->paginate(10);
        } else {

            $compras = $comprasQuery->whereBetween('created_at', [Carbon::today()->subDays(1), Carbon::today()->addDay(1)])->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('livewire.administrador.reporte.compra-fecha-livewire', compact('compras'))->layout('layouts.administrador.index');
    }
}
