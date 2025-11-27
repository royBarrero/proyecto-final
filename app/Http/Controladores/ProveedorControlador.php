<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Modelos\Proveedor;
use App\Exports\ProveedoresExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class ProveedorControlador extends Controlador
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('id', 'asc')->get();
        return response()->view('proveedores.mostrar', compact('proveedores'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create()
    {
        return response()->view('proveedores.crear')->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'direccion' => 'nullable|max:250',
            'telefono' => 'nullable|max:30',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return response()->view('proveedores.editar', compact('proveedor'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'direccion' => 'nullable|max:250',
            'telefono' => 'nullable|max:30',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }
    /**
 * Exportar a Excel
 */
public function exportarExcel()
{
    $proveedores = Proveedor::all();
    return Excel::download(new ProveedoresExport($proveedores), 'proveedores_' . date('Y-m-d') . '.xlsx');
}

/**
 * Exportar a PDF
 */
public function exportarPDF()
{
    $proveedores = Proveedor::all();
    $pdf = Pdf::loadView('proveedores.pdf', compact('proveedores'));
    return $pdf->download('proveedores_' . date('Y-m-d') . '.pdf');
}
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
