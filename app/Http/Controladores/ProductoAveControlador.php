<?php
namespace App\Http\Controladores;

use App\Modelos\ProductoAve;
use App\Modelos\Categoria;
use App\Modelos\Detalleave;
use Illuminate\Http\Request;
use App\Modelos\Fotoave;

class ProductoAveControlador extends Controlador
{
    public function index()
    {
        $aves = ProductoAve::with(['categoria', 'detalleAve'])->orderBy('id', 'asc')->get();
        return response()->view('productoAves.principal', compact('aves'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
 
    public function create()
    {
        $categorias = Categoria::all();
        
        // Solo detalles que NO están asignados a productos
        $detalles = Detalleave::whereNotIn('id', function($query) {
            $query->select('iddetalleaves')->from('productoaves');
        })->get();
        
        return response()->view('productoaves.create', compact('categorias', 'detalles'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'precio' => 'required|numeric|min:0',
            'idcategorias' => 'required|exists:categorias,id',
            'iddetalleaves' => 'required|exists:detalleaves,id|unique:productoaves,iddetalleaves',
            'cantidad' => 'required|integer|min:0',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ], [
            'iddetalleaves.unique' => '⚠️ Este detalle de ave ya está asignado a otro producto. Por favor, selecciona un detalle diferente o edita el producto existente.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.min' => 'El precio debe ser mayor o igual a 0.',
            'idcategorias.required' => 'Debe seleccionar una categoría.',
            'iddetalleaves.required' => 'Debe seleccionar un detalle de ave.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.min' => 'La cantidad debe ser mayor o igual a 0.',
        ]);
        
        // Crear el producto
        $producto = ProductoAve::create($request->only([
            'nombre', 'precio', 'idcategorias', 'iddetalleaves', 'cantidad'
        ]));
        
        // Si hay fotos, guardarlas
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $nombreArchivo = time().'_'.$foto->getClientOriginalName();
                $foto->storeAs('imagenes', $nombreArchivo, 'public');
                Fotoave::create([
                    'nombrefoto' => $nombreArchivo,
                    'idproductoaves' => $producto->id
                ]);
            }
        }
        
        return redirect()->route('productos.index', ['tab' => 'aves'])
            ->with('success', '✓ Producto ave creado correctamente.');
    }

    public function show($id)
    {
        $productoAve = ProductoAve::with(['categoria', 'detalleAve'])->findOrFail($id);
        return response()->view('productoaves.mostrar', compact('productoAve'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function edit($id)
    {
        $productoAve = ProductoAve::findOrFail($id);
        $categorias = Categoria::all();
        
        // Detalles disponibles + el detalle actual del producto
        $detalles = Detalleave::whereNotIn('id', function($query) use ($id) {
            $query->select('iddetalleaves')
                  ->from('productoaves')
                  ->where('id', '!=', $id);
        })->get();
        
        return response()->view('productoAves.editar', compact('productoAve', 'categorias', 'detalles'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
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
        
        // Actualiza los datos del producto
        $productoave->update($request->only([
            'nombre', 'precio', 'idcategorias', 'cantidad'
        ]));

        // Si hay nuevas fotos, las guarda
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $nombreArchivo = time().'_'.$foto->getClientOriginalName();
                $foto->storeAs('imagenes', $nombreArchivo, 'public');
                Fotoave::create([
                    'nombrefoto' => $nombreArchivo,
                    'idproductoaves' => $productoave->id
                ]);
            }
        }
 
        return redirect()->route('productos.index', ['tab' => 'aves'])
            ->with('success', '✓ Producto ave actualizado correctamente.');
    }

    public function destroy($id)
    {
        $productoave = ProductoAve::findOrFail($id);
        $productoave->delete();
        
        return redirect()->route('productos.index', ['tab' => 'aves'])
            ->with('success', '✓ Producto ave eliminado correctamente.');
    }
}