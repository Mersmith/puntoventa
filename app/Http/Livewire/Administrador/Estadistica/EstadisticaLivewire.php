<?php

namespace App\Http\Livewire\Administrador\Estadistica;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EstadisticaLivewire extends Component
{
    public function mount()
    {
        $productos_comprados = DB::select(
            'SELECT p.id as codigo, sum(cd.cantidad) as cantidad, p.nombre as nombre, p.id as id, p.stock_total as stock
            from productos p
            inner join compra_detalles cd on p.id=cd.producto_id
            inner join compras c on cd.compra_id=c.id where c.estado="1"
            and year(c.created_at)=year(curdate())
            group by p.id, p.nombre, p.id, p.stock_total
            order by sum(cd.cantidad)
            desc limit 10'
        );

        $productos_vendidos = DB::select(
            'SELECT p.id as codigo, sum(vd.cantidad) as cantidad, p.nombre as nombre, p.id as id, p.stock_total as stock
            from productos p
            inner join venta_detalles vd on p.id=vd.producto_id
            inner join ventas v on vd.venta_id=v.id where v.estado="1"
            and year(v.created_at)=year(curdate())
            group by p.id, p.nombre, p.id, p.stock_total
            order by sum(vd.cantidad)
            desc limit 10'
        );
    }

    public function render()
    {
        $totales = DB::select(
            'SELECT (select ifnull(sum(c.total), 0)
            from compras c 
            where DATE(c.created_at)=curdate() and c.estado = "1") as totalcompra, 
            (select ifnull(sum(v.total), 0)
            from ventas v 
            where DATE(v.created_at)=curdate() and v.estado="1") as totalventa'
        );


        $compras_mensuales = DB::select(
            'SELECT monthname(c.created_at) as mes, sum(c.total) as totalmes 
            from compras c where c.estado="1" 
            group by monthname(c.created_at)
            order by month(c.created_at) desc limit 12'
        );

        $ventas_mensuales = DB::select(
            'SELECT monthname(v.created_at) as mes, sum(v.total) as totalmes 
            from ventas v where v.estado="1" 
            group by monthname(v.created_at)
            order by month(v.created_at) desc limit 12'
        );

        /*$compras_dia = DB::select(
            'SELECT DATE_FORMAT(c.created_at, "%d/%m/%Y") as dia, sum(c.total) as totaldia 
            from compras c where c.estado="1"
            group by c.created_at 
            order by day(c.created_at) desc limit 7'
        );*/

        /*$compras_dia = DB::select(
            'SELECT dayname(c.created_at) as dia, sum(c.total) as totaldia 
            from compras c where c.estado="1"
            group by dayname(c.created_at)
            order by day(c.created_at) asc limit 7'
        );*/

        $compras_dia = DB::select(
            'SELECT DATE_FORMAT(c.created_at, "%d/%m/%Y") as dia, sum(c.total) as totaldia 
            from compras c where c.estado="1"
            group by DATE_FORMAT(c.created_at, "%d/%m/%Y")
            order by c.created_at desc limit 7'
        );

        return view('livewire.administrador.estadistica.estadistica-livewire', compact('totales', 'compras_mensuales', 'ventas_mensuales', 'compras_dia'))->layout('layouts.administrador.index');
    }
}
