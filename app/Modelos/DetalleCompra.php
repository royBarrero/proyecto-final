<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detallecompras';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idcompras',
        'idproductoalimentos',
        'cantidad',
        'preciounitario',
        'subtotal',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'idcompras');
    }

    public function producto()
    {
        return $this->belongsTo(ProductoAlimento::class, 'idproductoalimentos');
    }
}
