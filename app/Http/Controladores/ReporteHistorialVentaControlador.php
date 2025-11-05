<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Http\Controladores\Controlador;
use App\Modelos\Pedido as Venta;
use App\Modelos\MetodoPago;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteHistorialVentaControlador extends Controlador
{
    // Mostrar historial de ventas con filtros
    public function index(Request $request)
    {
        $metodos = MetodoPago::all();

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

        // Paginación
        $ventas = $query->orderBy('fecha', 'desc')->paginate(15);

        return view('reportes.ventas.historial', compact('ventas', 'metodos'));
    }

    // Generar PDF del historial filtrado
    public function generar(Request $request)
    {
        $query = Venta::with(['cliente', 'vendedor', 'pagos.metodoPago']);

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

        $pdf = Pdf::loadView('reportes.ventas.historial_pdf', compact('ventas'));
        return $pdf->download('historial_ventas.pdf');
    }
}
