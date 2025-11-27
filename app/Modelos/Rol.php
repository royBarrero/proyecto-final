<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use App\Modelos\Usuario;
use App\Modelos\Permiso;

class Rol extends Model
{
    protected $table = 'rols';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['descripcion'];
    
    /**
     * Relación: Un rol tiene muchos usuarios
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idrols');
    }

    /**
     * Relación muchos a muchos con Permisos
     */
    public function permisos()
    {
        return $this->belongsToMany(
            Permiso::class, 
            'rol_permiso', 
            'rol_id', 
            'permiso_id'
        )->withTimestamps();
    }

    /**
     * Verificar si el rol tiene un permiso específico
     */
    public function tienePermiso(string $nombrePermiso): bool
    {
        return $this->permisos()->where('nombre', $nombrePermiso)->exists();
    }

    /**
     * Asignar permisos al rol (reemplaza los existentes)
     */
    public function asignarPermisos(array $permisosIds): void
    {
        $this->permisos()->sync($permisosIds);
    }

    /**
     * Agregar permisos al rol (sin quitar los existentes)
     */
    public function agregarPermisos(array $permisosIds): void
    {
        $this->permisos()->syncWithoutDetaching($permisosIds);
    }

    /**
     * Quitar permisos del rol
     */
    public function quitarPermisos(array $permisosIds): void
    {
        $this->permisos()->detach($permisosIds);
    }

    /**
     * Quitar todos los permisos del rol
     */
    public function quitarTodosLosPermisos(): void
    {
        $this->permisos()->detach();
    }

    /**
     * Obtener los IDs de los permisos asignados al rol
     */
    public function obtenerIdsPermisos(): array
    {
        return $this->permisos()->pluck('permisos.id')->toArray();
    }
}