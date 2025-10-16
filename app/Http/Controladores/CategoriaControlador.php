<?php
namespace App\Http\Controladores;

use App\Modelos\Categoria;
use Illuminate\Http\Request;

class CategoriaControlador extends Controlador
{
    // Listar todas
    public function index()
    {
        $categorias = Categoria::all();
        return response()
    ->view('categorias.index', compact('categorias'))
    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');

    }

    // Mostrar formulario de crear
    public function create()
    {
        return view('vendedores.categorias.crear');
    }

    // Guardar
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create($request->all());
        return redirect()->route('categorias.index')->with('success','Categoría creada correctamente');
    }

    // Mostrar detalle
    public function show(Categoria $categoria)
    {
        return view('vendedores.categorias.mostrar', compact('categoria'));
    }

    // Formulario editar
    public function edit(Categoria $categoria)
    {
        return view('vendedores.categorias.editar', compact('categoria'));
    }

    // Actualizar
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());
        return redirect()->route('categorias.index')->with('success','Categoría actualizada correctamente');
    }

    // Eliminar
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success','Categoría eliminada correctamente');
    }
}
