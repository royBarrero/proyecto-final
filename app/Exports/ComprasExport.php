<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComprasExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $compras;

    public function __construct($compras)
    {
        $this->compras = $compras;
    }

    public function collection()
    {
        return $this->compras->map(function($compra, $index) {
            return [
                'ID' => $compra->id,
                'Fecha' => \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y'),
                'Proveedor' => $compra->proveedor->nombre,
                'Total' => 'Bs ' . number_format($compra->total, 2),
                'Estado' => $compra->estado,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Fecha', 'Proveedor', 'Total', 'Estado'];
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
            'A' => 10,
            'B' => 15,
            'C' => 30,
            'D' => 15,
            'E' => 15,
        ];
    }
}