<?php
namespace App\Http\Controladores;

use App\Modelos\ProductoAve;
use App\Modelos\Categoria;
use App\Modelos\DetalleAve;
use Illuminate\Http\Request;

class ProductoAveControlador extends Controlador
{
    public function index()
    {
        $aves = ProductoAve::with(['categoria', 'detalleAve'])->get();
        return view('productoAves.principal', compact('aves'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $detalles = DetalleAve::all();
        return view('productoAves.create', compact('categorias', 'detalles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
            'idcategorias' => 'required|exists:categorias,id',
            'iddetalleAves' => 'required|exists:detalleAves,id|unique:productoAves,iddetalleAves',
            'cantidad' => 'required|integer|min:0'
        ]);

        ProductoAve::create($request->all());
        return redirect()->route('productoAves.principal')->with('success', 'Producto creado correctamente.');
    }

    public function show(ProductoAve $productoAve)
    {
        return view('productoAves.mostrar', compact('productoAve'));
    }

    public function edit(ProductoAve $productoAve)
    {
        $categorias = Categoria::all();
        $detalles = DetalleAve::all();
        return view('productoAves.editar', compact('productoAve', 'categorias', 'detalles'));
    }

    public function update(Request $request, ProductoAve $productoAve)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
            'idcategorias' => 'required|exists:categorias,id',
            'iddetalleAves' => 'required|exists:detalleAves,id|unique:productoAves,iddetalleAves,' . $productoAve->id,
            'cantidad' => 'required|integer|min:0'
        ]);

        $productoAve->update($request->all());
        return redirect()->route('productoAves.mostrar')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(ProductoAve $productoAve)
    {
        $productoAve->delete();
        return redirect()->route('productoAves.mostrar')->with('success', 'Producto eliminado correctamente.');
    }
}
