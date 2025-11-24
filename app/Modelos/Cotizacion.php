<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'total',
        'validez',
        'idclientes',
    ];

    protected $casts = [
        'fecha' => 'date',
        'total' => 'decimal:2',
        'validez' => 'integer',
    ];

    /**
     * Relación: Una cotización pertenece a un cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'idclientes');
    }

    /**
     * Relación: Una cotización tiene muchos detalles
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCotizacion::class, 'idcotizaciones');
    }
}
