<?php

namespace App\Http\Controladores;

use App\Modelos\Auditoria;

class AuditoriaControlador extends Controlador
{
    public function index()
    {
        // Cargar también el usuario relacionado
        $auditorias = Auditoria::with('usuario')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return response()->view('auditorias.bitacora', compact('auditorias'))
                    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
    }

    // Eliminar una auditoría específica
    public function destroy($id)
    {
        $auditoria = Auditoria::findOrFail($id);
        $auditoria->delete();

        return redirect()->route('auditorias.index')
                         ->with('success', 'Registro de auditoría eliminado correctamente.');
    }

    // Eliminar todas las auditorías
    public function destroyAll()
    {
        Auditoria::truncate();
        return redirect()->route('auditorias.index')
                         ->with('success', 'Todas las auditorías fueron eliminadas.');
    }
}
