<?php

namespace App\Http\Controladores;

use App\Modelos\Fotoave;
use App\Modelos\ProductoAve;
use Illuminate\Http\Request;

class FotoaveControlador extends Controlador
{
    // 📜 Listar todas las fotos
    public function index()
    {
        $fotos = Fotoave::with('productoAve')
            ->whereHas('productoAve', function ($query) {
                $query->whereIn('nombre', ['pollo', 'huevo']);
            })->orderBy('id', 'asc')->get();

        // Separar por tipo
        $fotoaves = $fotos->filter(fn($foto) => $foto->productoAve && $foto->productoAve->nombre === 'pollo');
        $fotohuevos = $fotos->filter(fn($foto) => $foto->productoAve && $foto->productoAve->nombre === 'huevo');
        return response()->view('index', compact('fotoaves', 'fotohuevos'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // ➕ Mostrar formulario para subir una nueva foto
    public function create()
    {
        $productos = ProductoAve::all();
        return response()->view('fotoAves.create', compact('productos'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // 💾 Guardar una foto
    public function store(Request $request)
    {
        $request->validate([
            'nombreFoto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'idproductoAves' => 'required|exists:productoAves,id',
        ]);

        // Guardar imagen en storage/public/imagenes
        $ruta = $request->file('nombreFoto')->store('imagenes', 'public');

        Fotoave::create([
            'nombreFoto' => $ruta,
            'idproductoAves' => $request->idproductoAves
        ]);

        return redirect()->route('fotoaves.index')->with('success', 'Foto subida correctamente.');
    }

    // 🔍 Mostrar una foto
    public function show($id)
    {
        $fotoAve = Fotoave::findOrFail($id);
        return response()->view('fotoaves.show', compact('fotoAve'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    public function edit($id)
    {
        $fotoAve = Fotoave::findOrFail($id);
        $productos = ProductoAve::all();

        return response()
            ->view('fotoAves.editar', compact('fotoAve', 'productos'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    // 🔄 Actualizar una foto
    public function update(Request $request, $id)
    {
        $fotoAve = Fotoave::findOrFail($id);

        $request->validate([
            'nombrefoto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Eliminar imagen anterior si existe
        $rutaAnterior = public_path('imagenes/aves/' . $fotoAve->nombrefoto);
        if ($fotoAve->nombrefoto && file_exists($rutaAnterior)) {
            unlink($rutaAnterior);
        }

        // Guardar nueva imagen
        $archivo = $request->file('nombrefoto');
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $archivo->move(public_path('imagenes/aves'), $nombreArchivo);

        // Actualizar registro
        $fotoAve->update([
            'nombrefoto' => $nombreArchivo
        ]);

        return redirect()->route('fotoaves.index')->with('success', 'Foto actualizada correctamente.');
    }

    // 🗑 Eliminar una foto
    public function destroy($id)
    {
        $fotoAve = Fotoave::findOrFail($id);
        $fotoAve->delete();
        return redirect()->route('bienvenido.usuarios.vendedor')->with('error', 'Foto eliminada correctamente.');
    }
}
