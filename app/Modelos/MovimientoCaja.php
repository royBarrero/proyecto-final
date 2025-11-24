<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoCaja extends Model
{
    protected $table = 'movimientoscaja';
    public $timestamps = false;

    protected $fillable = [
        'idcaja',
        'tipo',
        'descripcion',
        'monto',
        'fecha',
        'origen',
        'idreferencia',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'datetime',
    ];

    /**
     * Relación: Un movimiento pertenece a una caja
     */
    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'idcaja');
    }
}
