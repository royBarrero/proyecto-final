<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProductoAlimento extends Model
{
    protected $table = 'productoalimentos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nombre','precio','stock',];

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'idproductoalimentos','id');
    }
}
