<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AvesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $aves;

    public function __construct($aves)
    {
        $this->aves = $aves;
    }

    public function collection()
    {
        return $this->aves->map(function($ave, $index) {
            return [
                'N°' => $index + 1,
                'Nombre' => $ave->nombre,
                'Precio' => 'Bs ' . number_format($ave->precio, 2),
                'Categoría' => $ave->categoria->nombre ?? '-',
                'Detalle' => $ave->detalleAve->descripcion ?? '-',
                'Cantidad' => $ave->cantidad,
            ];
        });
    }

    public function headings(): array
    {
        return ['N°', 'Nombre', 'Precio', 'Categoría', 'Detalle Ave', 'Cantidad'];
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
            'B' => 30,
            'C' => 15,
            'D' => 20,
            'E' => 30,
            'F' => 12,
        ];
    }
}