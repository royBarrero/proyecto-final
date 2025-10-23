<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Modelos\Proveedor;

class ProveedorControlador extends Controlador
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('id', 'asc')->get();
        return view('proveedores.mostrar', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'direccion' => 'nullable|max:250',
            'telefono' => 'nullable|max:30',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.editar', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'direccion' => 'nullable|max:250',
            'telefono' => 'nullable|max:30',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
