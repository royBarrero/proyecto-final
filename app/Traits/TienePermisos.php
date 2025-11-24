<?php

namespace App\Traits;

trait TienePermisos
{
    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public function tienePermiso(string $nombrePermiso): bool
    {
        $rol = $this->rol()->with('permisos')->first();
        
        if (!$rol) {
            return false;
        }

        return $rol->permisos()->where('nombre', $nombrePermiso)->exists();
    }

    /**
     * Verificar si el usuario tiene alguno de los permisos especificados
     */
    public function tieneAlgunPermiso(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verificar si el usuario tiene todos los permisos especificados
     */
    public function tieneTodosLosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if (!$this->tienePermiso($permiso)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function tieneRol(string $nombreRol): bool
    {
        $rol = $this->rol;
        return $rol && strtolower($rol->descripcion) === strtolower($nombreRol);
    }

    /**
     * Verificar si el usuario tiene alguno de los roles especificados
     */
    public function tieneAlgunRol(array $roles): bool
    {
        $rol = $this->rol;
        
        if (!$rol) {
            return false;
        }

        foreach ($roles as $nombreRol) {
            if (strtolower($rol->descripcion) === strtolower($nombreRol)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Obtener todos los permisos del usuario
     */
    public function obtenerPermisos()
    {
        $rol = $this->rol()->with('permisos')->first();
        return $rol ? $rol->permisos : collect();
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function esAdministrador(): bool
    {
        return $this->tieneRol('Administrador');
    }

    /**
     * Verificar si el usuario es vendedor
     */
    public function esVendedor(): bool
    {
        return $this->tieneRol('Vendedor');
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function esCliente(): bool
    {
        return $this->tieneRol('Cliente');
    }

    /**
     * Obtener los nombres de los permisos del usuario
     */
    public function obtenerNombresPermisos(): array
    {
        return $this->obtenerPermisos()->pluck('nombre')->toArray();
    }

    /**
     * Verificar si el usuario puede acceder a un módulo
     */
    public function puedeAccederAlModulo(string $modulo): bool
    {
        $rol = $this->rol()->with('permisos')->first();
        
        if (!$rol) {
            return false;
        }

        return $rol->permisos()->where('modulo', $modulo)->exists();
    }
}