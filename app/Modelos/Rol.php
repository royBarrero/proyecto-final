<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoAve extends Model
{
    use HasFactory;

    protected $table = 'productoAves';

    protected $fillable = [
        'nombre',
        'precio',
        'idcategorias',
        'iddetalleAves',
        'cantidad'
    ];

    // Relaciones (si deseas)
    public function categoria() {
        return $this->belongsTo(Categoria::class, 'idcategorias');
    }

    public function detalleAve() {
        return $this->belongsTo(DetalleAve::class, 'iddetalleAves');
    }
}
