<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class CompraController extends Controller
{
    public function pdfCompra(Compra $compra, Request $request)
    {

        $estado = $compra->estado;
        $total = $compra->total;
        $impuesto = $compra->impuesto;
        $proveedor = $compra->proveedor->nombre;
        $personal = $compra->user->email;
        $fecha = $compra->created_at;

        $detalle_compra = $compra->compraDetalle;

        $data = [
            'titulo' => 'Factura Comercial',
            'fecha_descarga' => date('m/d/Y'),
            'estado' => $estado,
            'total' => $total,
            'impuesto' => $impuesto,
            'proveedor' => $proveedor,
            'personal' => $personal,
            'fecha' => $fecha,
            'detalle_compra' => $detalle_compra
        ];

        $pdf = Pdf::loadView('pdf.factura-compra', $data);

        return $pdf->download('factura-compra.pdf');
    }

    public function imprimirCompra(Compra $compra, Request $request)
    {

        try {
            $estado = $compra->estado;
            $total = $compra->total;
            $impuesto = $compra->impuesto;
            $proveedor = $compra->proveedor->nombre;
            $personal = $compra->user->email;
            $fecha = $compra->created_at;

            $detalle_compra = $compra->compraDetalle;

            $data = [
                'titulo' => 'Factura Comercial',
                'fecha_descarga' => date('m/d/Y'),
                'estado' => $estado,
                'total' => $total,
                'impuesto' => $impuesto,
                'proveedor' => $proveedor,
                'personal' => $personal,
                'fecha' => $fecha,
                'detalle_compra' => $detalle_compra
            ];

            $nombreImpresora  = "TM20";
            $connector = new WindowsPrintConnector($nombreImpresora);
            $impresora = new Printer($connector);

            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setTextSize(2, 2);
            $impresora->text("Imprimiendo\n");
            $impresora->text("ticket\n");
            $impresora->text("desde\n");
            $impresora->text("Laravel\n");
            $impresora->setTextSize(1, 1);
            $impresora->text("https://parzibyte.me");

            $impresora->cut();
            $impresora->close();

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'No esta conectado la impresora');
        }
    }
}
