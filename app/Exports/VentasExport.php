<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $ventas;

    public function __construct($ventas)
    {
        $this->ventas = $ventas;
    }

    public function collection()
    {
        return collect($this->ventas)->map(function($venta, $index) {
            return [
                'N°' => $index + 1,
                'Cliente' => $venta->cliente ?? '-',
                'Vendedor' => $venta->vendedor ?? '-',
                'Método de Pago' => $venta->metodo_pago ?? '-',
                'Total' => 'Bs ' . number_format($venta->total, 2),
                'Fecha' => \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['N°', 'Cliente', 'Vendedor', 'Método de Pago', 'Total', 'Fecha'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 15,
        ];
    }
}