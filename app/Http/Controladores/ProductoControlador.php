<?php

namespace App\Http\Controladores;

use App\Modelos\ProductoAve;
use App\Modelos\ProductoAlimento;
use App\Exports\AlimentosExport;
use App\Exports\AvesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductoControlador extends Controlador
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'alimentos');
        
        $alimentos = ProductoAlimento::orderBy('id', 'asc')->get();
        $aves = ProductoAve::with(['categoria', 'detalleAve'])->orderBy('id', 'asc')->get();

        return response()
            ->view('productos.index', compact('alimentos', 'aves', 'tab'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    /**
     * Exportar alimentos a Excel
     */
    public function exportarAlimentosExcel()
    {
        $alimentos = ProductoAlimento::all();
        return Excel::download(new AlimentosExport($alimentos), 'alimentos_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Exportar alimentos a PDF
     */
    public function exportarAlimentosPDF()
    {
        $alimentos = ProductoAlimento::all();
        $pdf = Pdf::loadView('productos.alimentos-pdf', compact('alimentos'));
        return $pdf->download('alimentos_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exportar aves a Excel
     */
    public function exportarAvesExcel()
    {
        $aves = ProductoAve::with(['categoria', 'detalleAve'])->get();
        return Excel::download(new AvesExport($aves), 'aves_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Exportar aves a PDF
     */
    public function exportarAvesPDF()
    {
        $aves = ProductoAve::with(['categoria', 'detalleAve'])->get();
        $pdf = Pdf::loadView('productos.aves-pdf', compact('aves'));
        return $pdf->download('aves_' . date('Y-m-d') . '.pdf');
    }
}
