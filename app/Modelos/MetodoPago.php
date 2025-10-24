<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodopagos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['descripcion'];
}
