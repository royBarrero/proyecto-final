<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detallepedidos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idpedidos',
        'idproductoaves',
        'cantidad',
        'preciounitario',
        'subtotal',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idpedidos');
    }

    public function producto()
    {
        return $this->belongsTo(ProductoAve::class, 'idproductoaves');
    }
}
