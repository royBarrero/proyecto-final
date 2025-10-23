<?php

namespace App\Http\Controladores;

use App\Modelos\Detalleave;
use Illuminate\Http\Request;

class DetalleaveControlador extends Controlador
{
    public function index()
    {
        $detalleaves = Detalleave::orderBy('id', 'asc')->get();
         
        return view('detalleAves.mostrar', compact('detalleaves'));
    }
    public function show($id)
    {
        $detalleAve = Detalleave::findOrFail($id);
        return view('detalleAves.mostrarDetalle', compact('detalleAve'));
    }
    public function create()
    {
        return view('detalleAves.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'edad' => 'required|string|max:7',
        ]);

        Detalleave::create($request->all());
        return redirect()->route('detalleaves.index')->with('success', 'Detalle de ave creado correctamente.');
    }

    public function edit($id)
    {
        $detalleave = Detalleave::findOrFail($id);
        return view('detalleAves.editar', compact('detalleave'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'edad' => 'required|string|max:7',
        ]);

        $detalleave = Detalleave::findOrFail($id);
        $detalleave->update($request->all());

        return redirect()->route('detalleaves.index')->with('success', 'Detalle actualizado correctamente.');
    }

    public function destroy($id)
    {
        Detalleave::findOrFail($id)->delete();
        return redirect()->route('detalleaves.index')->with('success', 'Detalle eliminado correctamente.');
    }
}
