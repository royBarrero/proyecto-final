<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('acceso')
                ->with('error', 'Debe iniciar sesión para acceder.');
        }

        $usuario = auth()->user();

        // Verificar si el usuario tiene el permiso requerido
        if (!$usuario->tienePermiso($permiso)) {
            abort(403, 'No tiene permisos para acceder a esta funcionalidad.');
        }

        return $next($request);
    }
}