<?php

namespace App\Http\Controladores;

use App\Modelos\ProductoAlimento;
use Illuminate\Http\Request;

class ProductoAlimentoControlador extends Controlador
{
    public function create()
    {
        return response()
            ->view('productoAlimentos.create')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
        ]);

        ProductoAlimento::create($request->all());

        return redirect()->route('productos.index', ['tab' => 'alimentos'])
            ->with('success', '✓ Producto alimento creado correctamente.');
    }

    public function edit($id)
    {
        $alimento = ProductoAlimento::findOrFail($id);
        return response()
            ->view('productoAlimentos.edit', compact('alimento'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function update(Request $request, $id)
    {
        $alimento = ProductoAlimento::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
        ]);

        $alimento->update($request->all());

        return redirect()->route('productos.index', ['tab' => 'alimentos'])
            ->with('success', '✓ Producto alimento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $alimento = ProductoAlimento::findOrFail($id);
        $alimento->delete();

        return redirect()->route('productos.index', ['tab' => 'alimentos'])
            ->with('success', '✓ Producto alimento eliminado correctamente.');
    }
}
