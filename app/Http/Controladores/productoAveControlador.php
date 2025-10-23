<?php
namespace App\Http\Controladores;

use App\Modelos\ProductoAve;
use App\Modelos\Categoria;
use App\Modelos\Detalleave;
use Illuminate\Http\Request;
use App\Modelos\Fotoave;

class ProductoaveControlador extends Controlador
{
    public function index()
    {
        $aves = ProductoAve::with(['categoria', 'detalleAve'])->orderBy('id', 'asc')->get();
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
            'cantidad' => 'required|integer|min:0',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
         // Crear el producto
        $producto = ProductoAve::create($request->only([
            'nombre', 'precio', 'idcategorias', 'iddetalleAves', 'cantidad'
        ]));
        // Si hay fotos, guardarlas
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $nombreArchivo = time().'_'.$foto->getClientOriginalName();
                $foto->move(public_path('imagenes/aves'), $nombreArchivo);
                Fotoave::create([
                    'nombrefoto' => $nombreArchivo,
                    'idproductoaves' => $producto->id
                ]);
            }
        }
        return redirect()->route('productoaves.principal')->with('success', 'Producto creado correctamente.');
    }

    public function show($id)
    {
        $productoAve = ProductoAve::with(['categoria', 'detalleAve'])->findOrFail($id);
        return response()->view('productoaves.mostrar', compact('productoAve'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }

    public function edit($id)
    {
        $productoAve = ProductoAve::findOrFail($id);
        $categorias = Categoria::all();
        $detalles = Detalleave::all();
        return response()->view('productoAves.editar', compact('productoAve', 'categorias', 'detalles'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
    }

    public function update(Request $request, $id)
    {
        $productoave = ProductoAve::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
            'idcategorias' => 'required|exists:categorias,id',
            'cantidad' => 'required|integer|min:0',
            'fotos' => 'nullable|array',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        // 🔄 Actualiza los datos del producto
        $productoave->update($request->only([
            'nombre', 'precio', 'idcategorias', 'cantidad'
        ]));

        // 📸 Si hay nuevas fotos, las guarda sin borrar las antiguas
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $nombreArchivo = time().'_'.$foto->getClientOriginalName();
                $foto->move(public_path('imagenes/aves'), $nombreArchivo);
                Fotoave::create([
                    'nombrefoto' => $nombreArchivo,
                    'idproductoaves' => $productoave->id
                ]);
            }
        }
 
        return redirect()->route('productoaves.index')->with('warning', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $productoave = ProductoAve::findOrFail($id);
        $productoave->delete();
        return redirect()->route('productoaves.index')->with('error', 'Producto eliminado correctamente.');
    }
}
