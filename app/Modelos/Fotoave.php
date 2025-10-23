<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotoave extends Model
{
    use HasFactory;

    protected $table = 'fotoaves';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombrefoto',
        'idproductoaves',
    ];

    public function productoAve()
    {
        return $this->belongsTo(Productoave::class, 'idproductoaves','id');
    }
    
}
