<?php

namespace App\Http\Controladores;

use App\Modelos\Caja;
use App\Modelos\Pago;
use App\Modelos\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CajaControlador extends Controlador
{
    /**
     * Mostrar la vista principal de la caja con la caja abierta (si existe)
     */
    public function index()
    {
        $usuario = Auth::user();

        $cajaA = Caja::where('idusuarios', $usuario->id)
                    ->where('estado', 'abierta')
                    ->first();
        $cajaCerrada = Caja::where('idusuarios', $usuario->id)
                ->where('estado', 'cerrada')
                ->orderBy('fecha_cierre', 'desc')
                ->get(); // 👈 AQUÍ EL CAMBIO
        return view('administracionDEfinanzas.gestionarCaja.index', compact('cajaA','cajaCerrada'));
    }

    /**
     * Mostrar el formulario para abrir caja
     */
    public function formAbrir()
    {
        return view('administracionDEfinanzas.gestionarCaja.abrir');
    }

    /**
     * Abrir una nueva caja
     */
    public function abrir(Request $request)
    {
        $request->validate([
            'monto_inicial' => 'required|numeric|min:0'
        ]);

        $usuario = Auth::user();

        $cajaAbierta = Caja::where('idusuarios', $usuario->id)
                           ->where('estado', 'abierta')
                           ->first();
        if ($cajaAbierta) {
            return back()->with('error', 'Ya tiene una caja abierta.');
        }

        Caja::create([
            'monto_inicial' => $request->monto_inicial,
            'estado' => 'abierta',
            'idusuarios' => $usuario->id
        ]);

        return redirect()->route('caja.index')->with('success', 'Caja abierta correctamente.');
    }

    /**
     * Mostrar formulario para registrar un pago en la caja
     */
    public function formPago($idcaja)
    {
        $caja = Caja::findOrFail($idcaja);

        if ($caja->estado != 'abierta') {
            return redirect()->route('caja.index')->with('error', 'No se pueden registrar pagos en una caja cerrada.');
        }

        $metodos = MetodoPago::all();

        return view('administracionDEfinanzas.gestionarCaja.pagos', compact('caja', 'metodos'));
    }

    /**
     * Registrar un pago (ingreso o egreso)
     */
    public function registrarPago(Request $request)
    {
        $request->validate([
            'idcaja' => 'required|exists:cajas,id',
            'idmetodopagos' => 'required|exists:metodopagos,id',
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
            'origen' => 'nullable|string|max:50',
            'idreferencia' => 'nullable|integer'
        ]);

        $caja = Caja::findOrFail($request->idcaja);
        // Calcular saldo actual antes del movimiento
        $saldo = $caja->monto_inicial;
        foreach ($caja->pagos as $p) {
            $saldo += ($p->tipo == 'ingreso') ? $p->monto : -$p->monto;
        }

        // Si es egreso y no hay saldo suficiente
        if ($request->tipo == 'egreso' && $request->monto > $saldo) {
            return back()->with('error', 'No se puede registrar el egreso. Saldo insuficiente.');
        }

        if ($caja->estado != 'abierta') {
            return back()->with('error', 'No se puede registrar pagos en una caja cerrada.');
        }

        Pago::create([
            'idcaja' => $request->idcaja,
            'idmetodopagos' => $request->idmetodopagos,
            'tipo' => $request->tipo,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
            'origen' => $request->origen,
            'idreferencia' => $request->idreferencia,
            'fecha' => now(),
            'estado' => 1,  // pendiente o pagado según tu lógica
            'idpedidos' => $request->idpedidos ?? null,
        ]);




        return back()->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Consultar movimientos de caja
     */
    public function movimientos(Request $request, $idcaja)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date'
        ]);

        $caja = Caja::findOrFail($idcaja);

        $query = $caja->pagos();

        if ($request->fecha_inicio) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->fecha_fin) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        $pagos = $query->orderBy('fecha', 'asc')->get();

        $saldo = $caja->monto_inicial;
        foreach ($pagos as $pago) {
            $saldo += ($pago->tipo == 'ingreso') ? $pago->monto : -$pago->monto;
        }

        return view('administracionDEfinanzas.gestionarCaja.movimientos', compact('caja', 'pagos', 'saldo'));
    }

    /**
     * Cerrar caja
     */
    public function cerrar(Request $request, $idcaja)
    {
        $caja = Caja::findOrFail($idcaja);

        if ($caja->estado != 'abierta') {
            return back()->with('error', 'La caja ya está cerrada.');
        }

        $pagos = $caja->pagos;
        $monto_final = $caja->monto_inicial;
        foreach ($pagos as $pago) {
            $monto_final += ($pago->tipo == 'ingreso') ? $pago->monto : -$pago->monto;
        }

        $caja->update([
            'fecha_cierre' => now(),
            'monto_final' => $monto_final,
            'estado' => 'cerrada'
        ]);

        return redirect()->route('caja.index')->with('success', 'Caja cerrada correctamente.');
    }
    public function editarPago($id)
{
    $pago = Pago::findOrFail($id);
    $metodos = MetodoPago::all();
    return view('administracionDEfinanzas.gestionarCaja.editarPago', compact('pago', 'metodos'));
}

public function actualizarPago(Request $request, $id)
{
    $pago = Pago::findOrFail($id);

    $request->validate([
        'tipo' => 'required|in:ingreso,egreso',
        'monto' => 'required|numeric|min:0',
        'descripcion' => 'nullable|string|max:255',
        'idmetodopagos' => 'required|exists:metodopagos,id'
    ]);
    // Recalcular saldo sin este pago
    $saldo = $caja->monto_inicial;
    foreach ($caja->pagos()->where('id', '!=', $pago->id)->get() as $p) {
        $saldo += ($p->tipo == 'ingreso') ? $p->monto : -$p->monto;
    }

    // Verificar que el nuevo movimiento no deje saldo negativo
    if ($request->tipo == 'egreso' && $request->monto > $saldo) {
        return back()->with('error', 'No se puede actualizar. Saldo insuficiente.');
    }
    $pago->update([
        'tipo' => $request->tipo,
        'monto' => $request->monto,
        'descripcion' => $request->descripcion,
        'idmetodopagos' => $request->idmetodopagos,
    ]);

    return back()->with('success', 'Movimiento actualizado.');
}

public function eliminarPago($id)
{
    $pago = Pago::findOrFail($id);
    $pago->delete();

    return redirect()->route('caja.movimientos')->with('success', 'Movimiento eliminado.');
}

}
