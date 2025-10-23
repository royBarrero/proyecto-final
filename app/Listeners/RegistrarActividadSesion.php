<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Request;
use App\Modelos\Auditoria;

class RegistrarActividadSesion
{
    public function handle($event)
    {
        $accion = $event instanceof Login ? 'INICIO_SESION' : 'CIERRE_SESION';

        Auditoria::create([
            'tabla' => 'usuarios',
            'registro_id' => $event->user->id ?? null,
            'accion' => $accion,
            'usuario_id' => $event->user->id ?? null,
            'cambios' => ['nombre' => $event->user->name ?? 'Desconocido'],
            'ip' => Request::ip(),
        ]);
    }
}
