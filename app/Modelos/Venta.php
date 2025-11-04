<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    protected $table = 'pedidos';

    // Registrar una venta
    public static function registrarVenta($idCliente, $idVendedor, $total, $metodoPago, $detalles)
    {
        return DB::select('SELECT registrar_venta(?, ?, ?, ?, ?)', [
            $idCliente, $idVendedor, $total, $metodoPago, json_encode($detalles)
        ]);
    }

    // Listar ventas
    public static function listarVentas()
    {
        return DB::select('SELECT * FROM listar_ventas()');
    }

    // Obtener detalle de venta
    public static function detalleVenta($id)
    {
        return DB::select('SELECT * FROM obtener_detalle_venta(?)', [$id]);
    }

    // Actualizar venta
    public static function actualizarVenta($id, $total, $metodoPago)
    {
        return DB::select('SELECT actualizar_venta(?, ?, ?)', [$id, $total, $metodoPago]);
    }

    // Eliminar venta
    public static function eliminarVenta($id)
    {
        return DB::select('SELECT eliminar_venta(?)', [$id]);
    }
}
