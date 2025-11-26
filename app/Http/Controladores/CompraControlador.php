<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modelos\Compra;
use App\Modelos\DetalleCompra;
use App\Modelos\Proveedor;
use App\Modelos\ProductoAlimento;
use App\Exports\ComprasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraControlador extends Controlador
{
    public function index()
    {
        $compras = Compra::with('proveedor')->orderBy('id', 'desc')->get();
        return view('compras.mostrar', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = ProductoAlimento::all();
        return view('compras.crear', compact('proveedores', 'productos'));
    }

  public function store(Request $request)
{
    $request->validate([
        'idproveedors' => 'required|exists:proveedors,id',
        'productos' => 'required|array|min:1',
        'productos.*.idproductoalimentos' => 'required|exists:productoalimentos,id',
        'productos.*.cantidad' => 'required|numeric|min:1',
        'productos.*.preciounitario' => 'required|numeric|min:0',
    ], [
        'idproveedors.required' => 'Debe seleccionar un proveedor.',
        'productos.required' => 'Debe agregar al menos un producto.',
        'productos.*.cantidad.min' => 'La cantidad debe ser mayor a 0.',
    ]);

    DB::beginTransaction();
      $vendedor = \App\Modelos\Vendedor::where('idusuarios', auth()->id())->first();
    try {
        $total = 0;

        // Calcular total
        foreach ($request->productos as $detalle) {
            $total += $detalle['cantidad'] * $detalle['preciounitario'];
        }

        // Crear la compra
        $compra = Compra::create([
            'fecha' => now(),
            'estado' => 'Completado', // 👈 Ahora es texto
            'total' => $total,
            'idproveedors' => $request->idproveedors,
                'idvendedors' => $vendedor->id 
        ]);

        // Guardar detalles e incrementar stock
        foreach ($request->productos as $detalle) {
            DetalleCompra::create([
                'idcompras' => $compra->id,
                'idproductoalimentos' => $detalle['idproductoalimentos'],
                'cantidad' => $detalle['cantidad'],
                'preciounitario' => $detalle['preciounitario'],
                'subtotal' => $detalle['cantidad'] * $detalle['preciounitario'],
            ]);

            // Actualizar stock del producto
           $producto = ProductoAlimento::find($detalle['idproductoalimentos']);
            if ($producto) {
            $producto->stock = ($producto->stock ?? 0) + $detalle['cantidad'];
                $producto->save();
            }
        }

        DB::commit();
        return redirect()->route('compras.index')
            ->with('success', '✓ Compra registrada correctamente.');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->withErrors(['error' => 'Error al registrar la compra: ' . $e->getMessage()]);
    }
}
    public function show($id)
    {
        $compra = Compra::with(['proveedor', 'detalles.producto'])->findOrFail($id);
        return view('compras.detalle', compact('compra'));
    }
    /**
 * Exportar a Excel
 */
public function exportarExcel()
{
    $compras = Compra::with('proveedor')->get();
    return Excel::download(new ComprasExport($compras), 'compras_' . date('Y-m-d') . '.xlsx');
}

/**
 * Exportar a PDF
 */
public function exportarPDF()
{
    $compras = Compra::with('proveedor')->get();
    $pdf = Pdf::loadView('compras.pdf', compact('compras'));
    return $pdf->download('compras_' . date('Y-m-d') . '.pdf');
}
/**
 * Exportar detalle de compra a PDF
 */
public function exportarDetallePDF($id)
{
    $compra = Compra::with(['proveedor', 'detalles.producto'])->findOrFail($id);
    $pdf = Pdf::loadView('compras.detalle-pdf', compact('compra'));
    return $pdf->download('compra_' . $compra->id . '_' . date('Y-m-d') . '.pdf');
}
    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);

        DB::transaction(function () use ($compra) {
            foreach ($compra->detalles as $detalle) {
                // Restar el stock
                $producto = $detalle->producto;
                if ($producto) {
                    $producto->stock = max(0, $producto->stock - $detalle->cantidad);
                    $producto->save();
                }
                $detalle->delete();
            }
            $compra->delete();
        });

        return redirect()->route('compras.index')->with('success', 'Compra eliminada y stock actualizado.');
    }
}
