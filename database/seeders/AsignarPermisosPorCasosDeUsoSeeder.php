<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modelos\Rol;
use App\Modelos\Permiso;

class AsignarPermisosPorCasosDeUsoSeeder extends Seeder
{
    public function run(): void
    {
        // ROL: VENDEDOR (id=1) - 37 permisos
        $rolVendedor = Rol::find(1);
        if ($rolVendedor) {
            $permisosVendedor = Permiso::whereIn('nombre', [
                // Productos y Categorías
                'ver_productos', 'crear_productos', 'editar_productos', 'ver_disponibles',
                'ver_categorias', 'crear_categorias', 'editar_categorias',
                
                // Detalle Aves y Fotos
                'ver_detalle_aves', 'crear_detalle_aves', 'editar_detalle_aves',
                'ver_fotos', 'subir_fotos', 'editar_fotos',
                
                // Ventas y Carrito
                'ver_ventas', 'crear_ventas', 'ver_carrito',
                
                // Compras
                'ver_compras', 'crear_compras', 'ver_detalle_compras',
                
                // Proveedores
                'ver_proveedores', 'crear_proveedores', 'editar_proveedores',
                
                // Caja
                'ver_caja', 'abrir_caja', 'cerrar_caja', 'ver_movimientos_caja',
                'registrar_pagos',
                
                // Pagos
                'ver_pagos', 'crear_pagos',
                
                // Reportes
                'ver_reportes', 'generar_reporte_ventas', 'generar_reporte_compras',
                'ver_historial_ventas', 'exportar_reportes_pdf',
            ])->pluck('id')->toArray();
            
            $rolVendedor->permisos()->sync($permisosVendedor);
            $this->command->info('✅ VENDEDOR: ' . count($permisosVendedor) . ' permisos asignados');
        }

        // ROL: CLIENTE (id=2) - 6 permisos
        $rolCliente = Rol::find(2);
        if ($rolCliente) {
            $permisosCliente = Permiso::whereIn('nombre', [
                'ver_productos', 'ver_disponibles', 'ver_categorias',
                'ver_detalle_aves', 'ver_fotos', 'ver_carrito',
            ])->pluck('id')->toArray();
            
            $rolCliente->permisos()->sync($permisosCliente);
            $this->command->info('✅ CLIENTE: ' . count($permisosCliente) . ' permisos asignados');
        }

        // ROL: ADMINISTRADOR - TODOS los permisos
        $rolAdmin = Rol::where('descripcion', 'Administrador')->first();
        
        if (!$rolAdmin) {
            $rolAdmin = Rol::create(['descripcion' => 'Administrador']);
            $this->command->info('⚙️ Rol Administrador creado');
        }
        
        if ($rolAdmin) {
            $todosLosPermisos = Permiso::pluck('id')->toArray();
            $rolAdmin->permisos()->sync($todosLosPermisos);
            $this->command->info('✅ ADMINISTRADOR: ' . count($todosLosPermisos) . ' permisos (TODOS)');
        }
        
        $this->command->info('');
        $this->command->info('🎉 Permisos asignados según casos de uso del documento');
    }
}