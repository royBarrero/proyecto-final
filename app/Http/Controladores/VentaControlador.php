<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Modelos\Venta;
use App\Modelos\MetodoPago;
use App\Modelos\Cliente;
use App\Modelos\Vendedor;
use App\Modelos\ProductoAve;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaControlador extends Controlador
{
    public function index()
    {
        $ventas = Venta::listarVentas();
        return view('gestionarVentas.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $vendedores = Vendedor::all();
        $metodos = MetodoPago::all();
        $productos = ProductoAve::all();
        return view('gestionarVentas.gestionarCarrito.create', compact('clientes', 'vendedores', 'metodos', 'productos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_cliente' => 'required',
            'id_vendedor' => 'required',
            'total' => 'required|numeric',
            'metodo_pago' => 'required',
            'detalles' => 'required|json'
        ]);

        Venta::registrarVenta(
            $data['id_cliente'],
            $data['id_vendedor'],
            $data['total'],
            $data['metodo_pago'],
            json_decode($data['detalles'])
        );

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show($id)
    {
        $detalle = Venta::detalleVenta($id);
        return view('ventas.show', compact('detalle'));
    }
public function edit($id)
{
    $ventaRaw = Venta::listarVentas()[$id - 1] ?? null;
    
    if (!$ventaRaw) abort(404);
    
    // Obtener detalles de la venta
    $detalles = Venta::detalleVenta($id);
    
    // Normalizar nombres de columnas para la vista
    $venta = (object) [
        'id' => $ventaRaw->id ?? $ventaRaw->idventa ?? $id,
        'id_cliente' => $ventaRaw->id_cliente ?? $ventaRaw->idcliente ?? null,
        'id_vendedor' => $ventaRaw->id_vendedor ?? $ventaRaw->idvendedor ?? null,
        'metodo_pago' => $ventaRaw->metodo_pago ?? $ventaRaw->metodopago ?? null,
        'total' => $ventaRaw->total ?? 0,
        'detalles' => $detalles // Agregar detalles
    ];
    
    $clientes = Cliente::all();
    $vendedores = Vendedor::all();
    $metodos = MetodoPago::all();
    $productos = ProductoAve::all();
    
    return view('gestionarVentas.ventas.edit', compact(
        'venta', 
        'clientes', 
        'vendedores', 
        'metodos', 
        'productos'
    ));
}
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'total' => 'required|numeric',
            'metodo_pago' => 'required'
        ]);

        Venta::actualizarVenta($id, $data['total'], $data['metodo_pago']);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }
    // Método para exportar a Excel
public function exportarExcel()
{
    $ventas = Venta::listarVentas();
    return Excel::download(new VentasExport($ventas), 'ventas_' . date('Y-m-d') . '.xlsx');
}

// Método para exportar a PDF
public function exportarPDF()
{
    $ventas = Venta::listarVentas();
    $pdf = Pdf::loadView('gestionarVentas.ventas.pdf', compact('ventas'));
    return $pdf->download('ventas_' . date('Y-m-d') . '.pdf');
}
    public function destroy($id)
    {
        Venta::eliminarVenta($id);
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
}
 