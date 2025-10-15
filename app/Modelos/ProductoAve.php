<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;;
use Illuminate\Database\Eloquent\Model;

class ProductoAve extends Model
{
    protected $table = 'productoAves';   // 👈 tu tabla
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'nombre',
        'precio',
        'idcategorias',
        'iddetalleAves'
    ];
    public function productoAves()
    {
        return $this->hasMany(Usuario::class, 'idrols');
    }

}