<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Modelos\Compra;
use App\Modelos\Proveedor;
 // Requiere instalar barryvdh/laravel-dompdf
use Barryvdh\DomPDF\Facade\Pdf; 
class ReporteCompraControlador extends Controlador
{
    public function index(Request $request)
    {
        $proveedores = Proveedor::all();

        $query = Compra::with(['proveedor', 'detalles.producto']);

        // Filtros opcionales
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('idproveedors', $request->proveedor_id);
        }

        $compras = $query->orderBy('fecha', 'desc')->get();

        return view('reportes.compras.index', compact('compras', 'proveedores'));
    }

    public function exportarPDF(Request $request)
    {
        $query = Compra::with(['proveedor', 'detalles.producto']);

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('idproveedors', $request->proveedor_id);
        }

        $compras = $query->orderBy('fecha', 'desc')->get();

        $pdf = Pdf::loadView('reportes.compras.pdf', compact('compras'));

        return $pdf->download('reporte_compras.pdf');
    }
}
