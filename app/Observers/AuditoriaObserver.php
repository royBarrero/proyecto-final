<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Modelos\Auditoria;

class AuditoriaObserver
{
    /**
     * Método para capturar la creación
     */
    public function created($model)
    {
        $this->registrarCambio($model, 'CREAR');
    }

    /**
     * Método para capturar la actualización
     */
    public function updated($model)
    {
        $this->registrarCambio($model, 'ACTUALIZAR');
    }

    /**
     * Método para capturar la eliminación
     */
    public function deleted($model)
    {
        $this->registrarCambio($model, 'ELIMINAR');
    }

    /**
     * Función interna para guardar en auditoría
     */
    protected function registrarCambio($model, $accion)
    {
        // Obtenemos usuario actual
        $usuario_id = Auth::id();

        // Obtenemos cambios
        $cambios = null;

        if ($accion === 'ACTUALIZAR') {
            $cambios = [
                'antes'  => $model->getOriginal(),
                'despues'=> $model->getAttributes(),
            ];
        } elseif ($accion === 'CREAR') {
            $cambios = ['despues' => $model->getAttributes()];
        } elseif ($accion === 'ELIMINAR') {
            $cambios = ['antes' => $model->getOriginal()];
        }

        Auditoria::create([
            'tabla'       => $model->getTable(),
            'registro_id' => $model->id ?? null,
            'accion'      => $accion,
            'usuario_id'  => $usuario_id,
            'cambios'     => $cambios,
            'ip'          => Request::ip(),
        ]);
    }
}
