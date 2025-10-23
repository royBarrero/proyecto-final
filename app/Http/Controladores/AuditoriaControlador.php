<?php
namespace App\Http\Controladores;

use App\Modelos\Auditoria;

class AuditoriaControlador extends Controlador
{
    public function index()
    {
        $auditorias = Auditoria::orderBy('created_at', 'desc')->paginate(20);
        return view('auditorias.bitacora', compact('auditorias'));
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
        Auditoria::truncate(); // elimina todo
        return redirect()->route('auditorias.index')
                         ->with('success', 'Todas las auditorías fueron eliminadas.');
    }
}
