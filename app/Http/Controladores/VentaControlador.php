<?php

namespace App\Http\Controladores;

use Illuminate\Http\Request;
use App\Modelos\Venta;
use App\Modelos\MetodoPago;
use App\Modelos\Cliente;
use App\Modelos\Vendedor;
use App\Modelos\ProductoAve;

class VentaControlador extends Controlador
{
    public function index()
    {
        $ventas = Venta::listarVentas();
        return view('gestionarVentas.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $vendedores = Vendedor::all();
        $metodos = MetodoPago::all();
        $productos = ProductoAve::all();
        return view('gestionarVentas.gestionarCarrito.create', compact('clientes', 'vendedores', 'metodos', 'productos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_cliente' => 'required',
            'id_vendedor' => 'required',
            'total' => 'required|numeric',
            'metodo_pago' => 'required',
            'detalles' => 'required|json'
        ]);

        Venta::registrarVenta(
            $data['id_cliente'],
            $data['id_vendedor'],
            $data['total'],
            $data['metodo_pago'],
            json_decode($data['detalles'])
        );

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show($id)
    {
        $detalle = Venta::detalleVenta($id);
        return view('ventas.show', compact('detalle'));
    }

    public function edit($id)
    {
        $venta = Venta::listarVentas()[$id - 1] ?? null;
        $metodos = MetodoPago::all();
        if (!$venta) abort(404);
        return view('gestionarVentas.ventas.edit', compact('venta', 'metodos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'total' => 'required|numeric',
            'metodo_pago' => 'required'
        ]);

        Venta::actualizarVenta($id, $data['total'], $data['metodo_pago']);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
    {
        Venta::eliminarVenta($id);
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
}
