<?php

namespace App\Http\Livewire\Administrador\Compra;

use App\Models\Compra;
use Livewire\Component;

class CompraEditarLivewire extends Component
{
    public $compra;
    public $detalle_compra;

    public
        $estado,
        $total,
        $impuesto,
        $proveedor,
        $personal,
        $fecha;

    public function mount(Compra $compra)
    {
        $this->compra = $compra;

        $this->estado = $compra->estado;
        $this->total = $compra->total;
        $this->impuesto = $compra->impuesto;
        $this->proveedor = $compra->proveedor->nombre;
        $this->personal = $compra->user->email;
        $this->fecha = $compra->created_at;

        $this->detalle_compra = $compra->compraDetalle;
    }

    public function render()
    {
        return view('livewire.administrador.compra.compra-editar-livewire')->layout('layouts.administrador.index');
    }
}
