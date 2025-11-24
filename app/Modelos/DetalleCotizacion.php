<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCotizacion extends Model
{
    protected $table = 'detallecotizaciones';
    public $timestamps = false;

    protected $fillable = [
        'idcotizaciones',
        'idproductoaves',
        'cantidad',
        'preciounitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'preciounitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relación: Un detalle pertenece a una cotización
     */
    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'idcotizaciones');
    }

    /**
     * Relación: Un detalle referencia a un producto ave
     */
    public function productoAve(): BelongsTo
    {
        return $this->belongsTo(ProductoAve::class, 'idproductoaves');
    }
}
