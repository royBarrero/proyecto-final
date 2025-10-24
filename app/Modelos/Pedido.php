<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'estado',
        'total',
        'idclientes',
        'idvendedors'
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idclientes');
    }

    // Relación con Vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idvendedors');
    }

    // Relación con Pagos (un pedido puede tener varios pagos)
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'idpedidos');
    }
}
