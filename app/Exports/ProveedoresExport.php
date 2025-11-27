<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProveedoresExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $proveedores;

    public function __construct($proveedores)
    {
        $this->proveedores = $proveedores;
    }

    public function collection()
    {
        return $this->proveedores->map(function($proveedor, $index) {
            return [
                'N°' => $index + 1,
                'Nombre' => $proveedor->nombre,
                'Dirección' => $proveedor->direccion ?? '-',
                'Teléfono' => $proveedor->telefono ?? '-',
                'Email' => $proveedor->email ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['N°', 'Nombre', 'Dirección', 'Teléfono', 'Email'];
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
            'C' => 40,
            'D' => 15,
            'E' => 30,
        ];
    }
}