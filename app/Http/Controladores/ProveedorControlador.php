<?php
namespace App\Http\Controladores;

use App\Modelos\Productoave;
use App\Modelos\Categoria;
use App\Modelos\DetalleAve;
use Illuminate\Http\Request;

class ProveedorControlador extends Controlador
{
    public function index()
    {
        $aves = Productoave::with(['categoria', 'detalleAve'])->orderBy('id', 'asc')->get();
        return response()->view('productoaves.principal', compact('aves'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function create()
    {
        $categorias = Categoria::all();
        $detalles = DetalleAve::all();
        return response()->view('productoaves.create', compact('categorias', 'detalles'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
            'idcategorias' => 'required|exists:categorias,id',
            'iddetalleAves' => 'required|exists:detalleAves,id|unique:productoaves,iddetalleAves',
            'cantidad' => 'required|integer|min:0'
        ]);

        Productoave::create($request->all());
        return redirect()->route('productoaves.principal')->with('success', 'Producto creado correctamente.');
    }

    public function show($id)
    {
        $productoAve = Productoave::with(['categoria', 'detalleAve'])->findOrFail($id);
        return response()->view('productoaves.mostrar', compact('productoAve'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function edit($id)
    {
        $productoAve = Productoave::findOrFail($id);
        $categorias = Categoria::all();
        $detalles = DetalleAve::all();
        return response()->view('productoAves.editar', compact('productoAve', 'categorias', 'detalles'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
    }

    public function update(Request $request, $id)
    {
        $productoave = Productoave::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
            'idcategorias' => 'required|exists:categorias,id',
            'iddetalleAves' => 'required|exists:detalleAves,id|unique:productoaves,iddetalleAves,' . $productoave->id,
            'cantidad' => 'required|integer|min:0'
        ]);

        $productoave->update($request->all());
        return redirect()->route('productoaves.mostrar')->with('warning', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $productoave = Productoave::findOrFail($id);
        $productoave->delete();
        return redirect()->route('productoaves.mostrar')->with('error', 'Producto eliminado correctamente.');
    }
}
