<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\Productoave;

class Detalleave extends Model
{
    use HasFactory;

    protected $table = 'detalleaves';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'edad',
    ];
    // 🔗 Relación inversa (1 detalle puede tener 1 producto)
    public function productoAve()
    {
        return $this->hasOne(Productoave::class, 'iddetalleaves', 'id');
    }
}
