<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';
    public $timestamps = false;

    protected $fillable = [
        'tabla',
        'registro_id',
        'accion',
        'usuario_id',
        'cambios',
        'ip',
        'created_at'
    ];
    protected $casts = [
        'cambios' => 'array'
    ];
    public function usuario()
    {
        return $this->belongsTo(\App\Modelos\Usuario::class, 'usuario_id','id');
    }


}
