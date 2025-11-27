<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\Rol;

class Permiso extends Model
{
    protected $table = 'permisos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'modulo',
    ];

    /**
     * Relación muchos a muchos con Roles
     */
    public function roles()
    {
        return $this->belongsToMany(
            Rol::class, 
            'rol_permiso', 
            'permiso_id', 
            'rol_id'
        )->withTimestamps();
    }

    /**
     * Scope para filtrar permisos por módulo
     */
    public function scopePorModulo($query, string $modulo)
    {
        return $query->where('modulo', $modulo);
    }

    /**
     * Obtener permisos agrupados por módulo
     */
    public static function obtenerAgrupados()
    {
        return self::orderBy('modulo')->orderBy('nombre')->get()->groupBy('modulo');
    }
}