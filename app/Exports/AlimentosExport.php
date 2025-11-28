<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlimentosExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $alimentos;

    public function __construct($alimentos)
    {
        $this->alimentos = $alimentos;
    }

    public function collection()
    {
        return $this->alimentos->map(function($alimento, $index) {
            return [
                'N°' => $index + 1,
                'Nombre' => $alimento->nombre,
                'Precio' => 'Bs ' . number_format($alimento->precio, 2),
                'Stock' => $alimento->stock ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return ['N°', 'Nombre', 'Precio', 'Stock'];
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
            'B' => 40,
            'C' => 15,
            'D' => 12,
        ];
    }
}