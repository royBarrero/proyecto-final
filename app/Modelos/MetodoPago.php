<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodoPago extends Model
{
    protected $table = 'metodopagos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['descripcion'];

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'idmetodopagos', 'id');
    }
}
