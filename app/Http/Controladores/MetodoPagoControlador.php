<?php

namespace App\Http\Controladores;

use App\Http\Controllers\Controller;
use App\Modelos\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetodoPagoControlador extends Controlador
{
    /**
     * Mostrar lista de métodos de pago
     */
    public function index()
    {
        $metodos = MetodoPago::all();
        return view('metodoPago.index', compact('metodos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('metodoPago.create');
    }

    /**
     * Guardar nuevo método de pago
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:100|unique:metodopagos,descripcion',
        ], [
            'descripcion.required' => 'La descripción del método de pago es obligatoria.',
            'descripcion.unique' => 'Este método de pago ya existe.',
            'descripcion.max' => 'La descripción no puede exceder 100 caracteres.',
        ]);

        MetodoPago::create([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('metodopagos.index')
            ->with('success', '✓ Método de pago creado exitosamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $metodo = MetodoPago::findOrFail($id);
        return view('metodoPago.edit', compact('metodo'));
    }

    /**
     * Actualizar método de pago
     */
    public function update(Request $request, $id)
    {
        $metodo = MetodoPago::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:100|unique:metodopagos,descripcion,' . $id,
        ], [
            'descripcion.required' => 'La descripción del método de pago es obligatoria.',
            'descripcion.unique' => 'Este método de pago ya existe.',
            'descripcion.max' => 'La descripción no puede exceder 100 caracteres.',
        ]);

        $metodo->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('metodopagos.index')
            ->with('success', '✓ Método de pago actualizado exitosamente.');
    }

    /**
     * Eliminar método de pago
     */
    public function destroy($id)
    {
        $metodo = MetodoPago::findOrFail($id);

        // Verificar si el método está en uso en pagos
        $enUsoPagos = DB::table('pagos')->where('idmetodopagos', $id)->exists();
        
        // Verificar si está en uso en pedidos (si existe la tabla)
        $enUsoPedidos = DB::table('pedidos')->where('metodo_pago', $id)->exists();

        if ($enUsoPagos || $enUsoPedidos) {
            return redirect()->route('metodopagos.index')
                ->with('error', '⚠️ No se puede eliminar este método de pago porque está siendo utilizado en transacciones anteriores.');
        }

        $metodo->delete();

        return redirect()->route('metodopagos.index')
            ->with('success', '✓ Método de pago eliminado exitosamente.');
    }
}