<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caja extends Model
{
    protected $table = 'cajas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'fecha_apertura',
        'fecha_cierre',
        'monto_inicial',
        'monto_final',
        'estado',
        'idusuarios'
    ];

    // Relación: una caja pertenece a un usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'idusuarios', 'id');
    }

    // Relación: una caja tiene muchos pagos
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'idcaja', 'id');
    }

    /**
     * Relación: Una caja tiene muchos movimientos
     */
    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoCaja::class, 'idcaja');
    }

}
