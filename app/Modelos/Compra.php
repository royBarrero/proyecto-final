<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['fecha','estado','total','idproveedors','idvendedors'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idproveedors');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idvendedors');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'idcompras');
    }
}
