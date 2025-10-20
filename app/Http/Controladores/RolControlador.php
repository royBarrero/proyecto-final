<?php

namespace App\Http\Controladores;

use App\Modelos\Rol;
use Illuminate\Http\Request;

class RolControlador extends Controlador
{
    public function index()
    {
        $roles = Rol::orderBy('id', 'asc')->get();
        return response()->view('vendedores.roles.mostrar', compact('roles'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function create()
    {
        return response()->view('vendedores.roles.crear')->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50',
        ]);

        Rol::create($request->all());
        return redirect()->route('rols.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(Rol $rol)
    {
        return response()->view('vendedores.roles.mostrar', compact('rol'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function edit(Rol $rol)
    {
        return response()->view('vendedores.roles.editar', compact('rol'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50',
        ]);

        $rol->update($request->all());
        return redirect()->route('rols.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('rols.index')->with('success', 'Rol eliminado correctamente.');
    }
}
