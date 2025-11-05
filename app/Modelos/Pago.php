<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;


class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
    'fecha',
    'estado',
    'monto',
    'idpedidos',
    'idmetodopagos',
    'idcaja',
    'tipo',
    'descripcion',
    'origen',
    'idreferencia'
];
public function caja()
{
    return $this->belongsTo(Caja::class, 'idcaja');
}

    // Relación con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idpedidos');
    }

    // Relación con Método de Pago
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'idmetodopagos');
    }
}
