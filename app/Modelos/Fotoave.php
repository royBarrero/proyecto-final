<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\ProductoAve;

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

    public function productoave()
    {
        return $this->belongsTo(ProductoAve::class, 'idproductoaves', 'id');
    }


}
