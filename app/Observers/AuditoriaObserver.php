<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Modelos\Auditoria;

class AuditoriaObserver
{
    // Cuando se crea un registro
    public function created($model)
    {
        Auditoria::create([
            'tabla' => $model->getTable(),
            'registro_id' => $model->id,
            'accion' => 'CREAR',
            'usuario_id' => Auth::id(),
            'cambios' => $model->getAttributes(),
            'ip' => Request::ip(),
        ]);
    }

    // Cuando se actualiza un registro
    public function updated($model)
    {
        Auditoria::create([
            'tabla' => $model->getTable(),
            'registro_id' => $model->id,
            'accion' => 'ACTUALIZAR',
            'usuario_id' => Auth::id(),
            'cambios' => $model->getChanges(),
            'ip' => Request::ip(),
        ]);
    }

    // Cuando se elimina un registro
    public function deleted($model)
    {
        Auditoria::create([
            'tabla' => $model->getTable(),
            'registro_id' => $model->id,
            'accion' => 'ELIMINAR',
            'usuario_id' => Auth::id(),
            'cambios' => $model->getOriginal(),
            'ip' => Request::ip(),
        ]);
    }
}
