<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Http\Controladores\Controlador;
use App\Modelos\Pedido as Venta;
use App\Modelos\MetodoPago;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Modelos\Vendedor;

class ReporteVentaControlador extends Controlador
{
    // Mostrar la vista con filtro de ventas
public function index(Request $request)
{
    $metodos = MetodoPago::all();
    $vendedores = Vendedor::all(); // <-- obtenemos todos los vendedores

    $query = Venta::with(['cliente', 'vendedor', 'pagos.metodoPago']);

    // Filtros de fechas
    if ($request->filled('fecha_desde')) {
        $query->where('fecha', '>=', $request->fecha_desde);
    }
    if ($request->filled('fecha_hasta')) {
        $query->where('fecha', '<=', $request->fecha_hasta);
    }

    // Filtro por método de pago
    if ($request->filled('metodo_pago')) {
        $query->whereHas('pagos', function($q) use ($request) {
            $q->where('idmetodopagos', $request->metodo_pago);
        });
    }

    // Filtro por vendedor
    if ($request->filled('vendedor_id')) {
        $query->where('idvendedors', $request->vendedor_id);
    }

    $ventas = $query->orderBy('fecha', 'desc')->get();

    return view('reportes.ventas.historial', compact('ventas', 'metodos', 'vendedores'));
}

    // Generar PDF de las ventas filtradas
    public function generar(Request $request)
    {
        $query = Venta::with(['cliente', 'vendedor', 'pagos.metodoPago']);

        // Aplicar los mismos filtros que en index
        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }
        if ($request->filled('metodo_pago')) {
            $query->whereHas('pagos', function($q) use ($request) {
                $q->where('idmetodopagos', $request->metodo_pago);
            });
        }

        $ventas = $query->orderBy('fecha', 'desc')->get();

        // Generar PDF
        $pdf = Pdf::loadView('reportes.ventas.pdf', compact('ventas'));

        return $pdf->download('reporte_ventas.pdf');
    }
}
