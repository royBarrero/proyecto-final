<?php

namespace App\Http\Controladores;

use App\Modelos\Rol;
use App\Modelos\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolControlador extends Controlador
{
    public function index()
    {
        $roles = Rol::with('permisos')->orderBy('id', 'asc')->get();
        
        return response()->view('autenticacionYseguridad.roles.mostrar', compact('roles'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function create()
    {
        $permisos = Permiso::orderBy('modulo')->orderBy('nombre')->get();
        $permisosAgrupados = $permisos->groupBy('modulo');
        
        return response()->view('autenticacionYseguridad.roles.crear', compact('permisosAgrupados'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:rols,descripcion',
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permisos,id'
        ], [
            'descripcion.required' => 'La descripción del rol es obligatoria.',
            'descripcion.unique' => 'Ya existe un rol con esta descripción.',
            'descripcion.max' => 'La descripción no puede tener más de 50 caracteres.',
            'permisos.*.exists' => 'Uno o más permisos seleccionados no son válidos.'
        ]);

        DB::beginTransaction();
        
        try {
            $rol = Rol::create(['descripcion' => $request->descripcion]);

            if ($request->has('permisos')) {
                $rol->permisos()->attach($request->permisos);
            }

            DB::commit();

            return redirect()->route('rols.index')
                           ->with('success', 'Rol creado exitosamente con sus permisos.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }
    }

    public function show(Rol $rol)
    {
        $rol->load('permisos', 'usuarios');
        
        return response()->view('autenticacionYseguridad.roles.ver', compact('rol'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function edit(Rol $rol)
    {
        $rol->load('permisos');
        $permisos = Permiso::orderBy('modulo')->orderBy('nombre')->get();
        $permisosAgrupados = $permisos->groupBy('modulo');
        $permisosAsignados = $rol->permisos->pluck('id')->toArray();
        
        return response()->view('autenticacionYseguridad.roles.editar', compact('rol', 'permisosAgrupados', 'permisosAsignados'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:rols,descripcion,' . $rol->id,
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permisos,id'
        ], [
            'descripcion.required' => 'La descripción del rol es obligatoria.',
            'descripcion.unique' => 'Ya existe un rol con esta descripción.',
            'descripcion.max' => 'La descripción no puede tener más de 50 caracteres.',
            'permisos.*.exists' => 'Uno o más permisos seleccionados no son válidos.'
        ]);

        DB::beginTransaction();
        
        try {
            $rol->update(['descripcion' => $request->descripcion]);
            $rol->permisos()->sync($request->permisos ?? []);

            DB::commit();

            return redirect()->route('rols.index')
                           ->with('warning', 'Rol actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
        }
    }

    public function destroy(Rol $rol)
    {
        if ($rol->usuarios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el rol porque hay usuarios asignados a él.');
        }

        DB::beginTransaction();
        
        try {
            $rol->permisos()->detach();
            $rol->delete();

            DB::commit();

            return redirect()->route('rols.index')
                           ->with('error', 'Rol eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    public function gestionarPermisos(Rol $rol)
    {
        $rol->load('permisos');
        $permisos = Permiso::orderBy('modulo')->orderBy('nombre')->get();
        $permisosAgrupados = $permisos->groupBy('modulo');
        $permisosAsignados = $rol->permisos->pluck('id')->toArray();
        
        return response()->view('autenticacionYseguridad.roles.permisos', compact('rol', 'permisosAgrupados', 'permisosAsignados'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function actualizarPermisos(Request $request, Rol $rol)
    {
        $request->validate([
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permisos,id'
        ]);

        DB::beginTransaction();
        
        try {
            $rol->permisos()->sync($request->permisos ?? []);
            
            DB::commit();

            return redirect()->route('rols.index')
                           ->with('success', 'Permisos actualizados exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar permisos: ' . $e->getMessage());
        }
    }
}