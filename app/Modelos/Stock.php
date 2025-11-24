<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'stocks';
    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'estado',
        'fecha',
        'idproductoaves',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'fecha' => 'date',
    ];

    /**
     * Relación: Un stock pertenece a un producto ave
     */
    public function productoAve(): BelongsTo
    {
        return $this->belongsTo(ProductoAve::class, 'idproductoaves');
    }
}
