<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modelos\Rol;
use App\Modelos\Permiso;

class AsignarPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Rol: Vendedor (id=1)
        $rolVendedor = Rol::find(1);
        if ($rolVendedor) {
            $permisosVendedor = Permiso::whereIn('nombre', [
                'ver_productos', 'crear_productos', 'editar_productos', 'ver_disponibles',
                'ver_categorias', 'crear_categorias', 'editar_categorias',
                'ver_detalle_aves', 'crear_detalle_aves', 'editar_detalle_aves',
                'ver_fotos', 'subir_fotos', 'editar_fotos',
                'ver_ventas', 'crear_ventas', 'ver_carrito',
                'ver_compras', 'crear_compras', 'ver_detalle_compras',
                'ver_proveedores', 'crear_proveedores', 'editar_proveedores',
                'ver_caja', 'abrir_caja', 'cerrar_caja', 'ver_movimientos_caja', 'registrar_pagos',
                'ver_pagos', 'crear_pagos',
                'ver_reportes', 'generar_reporte_ventas', 'generar_reporte_compras', 
                'ver_historial_ventas', 'exportar_reportes_pdf',
            ])->pluck('id')->toArray();
            
            $rolVendedor->permisos()->sync($permisosVendedor);
            $this->command->info('✅ Permisos asignados al rol Vendedor');
        }

        // Rol: Cliente (id=2)
        $rolCliente = Rol::find(2);
        if ($rolCliente) {
            $permisosCliente = Permiso::whereIn('nombre', [
                'ver_productos', 'ver_disponibles', 'ver_categorias', 
                'ver_detalle_aves', 'ver_fotos', 'ver_carrito',
            ])->pluck('id')->toArray();
            
            $rolCliente->permisos()->sync($permisosCliente);
            $this->command->info('✅ Permisos asignados al rol Cliente');
        }
    }
}