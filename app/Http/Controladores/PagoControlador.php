<?php

namespace App\Http\Controladores;

use App\Http\Controllers\Controller;
use App\Modelos\Pago;
use App\Modelos\Pedido;
use App\Modelos\MetodoPago;
use Illuminate\Http\Request;

class PagoControlador extends Controlador
{
    public function index()
    {
        $pagos = Pago::with(['pedido', 'metodoPago'])->get();
        return view('pagos.mostrar', compact('pagos'));
    }

    public function create()
    {
        $pedidos = Pedido::all();
        $metodos = MetodoPago::all();
        return view('pagos.crear', compact('pedidos', 'metodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'estado' => 'required|integer',
            'monto' => 'required|numeric',
            'idpedidos' => 'required|integer',
            'idmetodopagos' => 'required|integer',
        ]);

        Pago::create($request->all());
        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function edit($id)
    {
        $pago = Pago::findOrFail($id);
        $pedidos = Pedido::all();
        $metodos = MetodoPago::all();
        return view('pagos.editar', compact('pago', 'pedidos', 'metodos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'estado' => 'required|integer',
            'monto' => 'required|numeric',
            'idpedidos' => 'required|integer',
            'idmetodopagos' => 'required|integer',
        ]);

        $pago = Pago::findOrFail($id);
        $pago->update($request->all());
        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
}
