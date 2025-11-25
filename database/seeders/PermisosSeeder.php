<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modelos\Permiso;
use Illuminate\Support\Facades\DB;

class PermisosSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Módulo: Usuarios
            ['nombre' => 'ver_usuarios', 'descripcion' => 'Ver listado de usuarios', 'modulo' => 'usuarios'],
            ['nombre' => 'crear_usuarios', 'descripcion' => 'Crear nuevos usuarios', 'modulo' => 'usuarios'],
            ['nombre' => 'editar_usuarios', 'descripcion' => 'Editar usuarios existentes', 'modulo' => 'usuarios'],
            ['nombre' => 'eliminar_usuarios', 'descripcion' => 'Eliminar usuarios', 'modulo' => 'usuarios'],

            // Módulo: Roles
            ['nombre' => 'ver_roles', 'descripcion' => 'Ver listado de roles', 'modulo' => 'roles'],
            ['nombre' => 'crear_roles', 'descripcion' => 'Crear nuevos roles', 'modulo' => 'roles'],
            ['nombre' => 'editar_roles', 'descripcion' => 'Editar roles existentes', 'modulo' => 'roles'],
            ['nombre' => 'eliminar_roles', 'descripcion' => 'Eliminar roles', 'modulo' => 'roles'],
            ['nombre' => 'gestionar_permisos', 'descripcion' => 'Gestionar permisos de roles', 'modulo' => 'roles'],

            // Módulo: Productos (Aves)
            ['nombre' => 'ver_productos', 'descripcion' => 'Ver listado de aves ornamentales', 'modulo' => 'productos'],
            ['nombre' => 'crear_productos', 'descripcion' => 'Crear nuevos productos de aves', 'modulo' => 'productos'],
            ['nombre' => 'editar_productos', 'descripcion' => 'Editar productos existentes', 'modulo' => 'productos'],
            ['nombre' => 'eliminar_productos', 'descripcion' => 'Eliminar productos', 'modulo' => 'productos'],
            ['nombre' => 'ver_disponibles', 'descripcion' => 'Ver productos disponibles', 'modulo' => 'productos'],

            // Módulo: Categorías
            ['nombre' => 'ver_categorias', 'descripcion' => 'Ver listado de categorías', 'modulo' => 'categorias'],
            ['nombre' => 'crear_categorias', 'descripcion' => 'Crear nuevas categorías', 'modulo' => 'categorias'],
            ['nombre' => 'editar_categorias', 'descripcion' => 'Editar categorías existentes', 'modulo' => 'categorias'],
            ['nombre' => 'eliminar_categorias', 'descripcion' => 'Eliminar categorías', 'modulo' => 'categorias'],

            // Módulo: Detalle Aves
            ['nombre' => 'ver_detalle_aves', 'descripcion' => 'Ver detalles de aves', 'modulo' => 'detalle_aves'],
            ['nombre' => 'crear_detalle_aves', 'descripcion' => 'Crear detalles de aves', 'modulo' => 'detalle_aves'],
            ['nombre' => 'editar_detalle_aves', 'descripcion' => 'Editar detalles de aves', 'modulo' => 'detalle_aves'],
            ['nombre' => 'eliminar_detalle_aves', 'descripcion' => 'Eliminar detalles de aves', 'modulo' => 'detalle_aves'],

            // Módulo: Fotos de Aves
            ['nombre' => 'ver_fotos', 'descripcion' => 'Ver fotos de aves', 'modulo' => 'fotos'],
            ['nombre' => 'subir_fotos', 'descripcion' => 'Subir fotos de aves', 'modulo' => 'fotos'],
            ['nombre' => 'editar_fotos', 'descripcion' => 'Editar fotos de aves', 'modulo' => 'fotos'],
            ['nombre' => 'eliminar_fotos', 'descripcion' => 'Eliminar fotos de aves', 'modulo' => 'fotos'],

            // Módulo: Ventas
            ['nombre' => 'ver_ventas', 'descripcion' => 'Ver listado de ventas', 'modulo' => 'ventas'],
            ['nombre' => 'crear_ventas', 'descripcion' => 'Registrar nuevas ventas', 'modulo' => 'ventas'],
            ['nombre' => 'editar_ventas', 'descripcion' => 'Editar ventas', 'modulo' => 'ventas'],
            ['nombre' => 'eliminar_ventas', 'descripcion' => 'Eliminar ventas', 'modulo' => 'ventas'],
            ['nombre' => 'ver_carrito', 'descripcion' => 'Ver carrito de compras', 'modulo' => 'ventas'],

            // Módulo: Compras
            ['nombre' => 'ver_compras', 'descripcion' => 'Ver listado de compras', 'modulo' => 'compras'],
            ['nombre' => 'crear_compras', 'descripcion' => 'Registrar nuevas compras', 'modulo' => 'compras'],
            ['nombre' => 'editar_compras', 'descripcion' => 'Editar compras existentes', 'modulo' => 'compras'],
            ['nombre' => 'eliminar_compras', 'descripcion' => 'Eliminar compras', 'modulo' => 'compras'],
            ['nombre' => 'ver_detalle_compras', 'descripcion' => 'Ver detalles de compras', 'modulo' => 'compras'],

            // Módulo: Proveedores
            ['nombre' => 'ver_proveedores', 'descripcion' => 'Ver listado de proveedores', 'modulo' => 'proveedores'],
            ['nombre' => 'crear_proveedores', 'descripcion' => 'Crear nuevos proveedores', 'modulo' => 'proveedores'],
            ['nombre' => 'editar_proveedores', 'descripcion' => 'Editar proveedores existentes', 'modulo' => 'proveedores'],
            ['nombre' => 'eliminar_proveedores', 'descripcion' => 'Eliminar proveedores', 'modulo' => 'proveedores'],

            // Módulo: Caja
            ['nombre' => 'ver_caja', 'descripcion' => 'Ver estado de caja', 'modulo' => 'caja'],
            ['nombre' => 'abrir_caja', 'descripcion' => 'Abrir caja', 'modulo' => 'caja'],
            ['nombre' => 'cerrar_caja', 'descripcion' => 'Cerrar caja', 'modulo' => 'caja'],
            ['nombre' => 'ver_movimientos_caja', 'descripcion' => 'Ver movimientos de caja', 'modulo' => 'caja'],
            ['nombre' => 'registrar_pagos', 'descripcion' => 'Registrar pagos en caja', 'modulo' => 'caja'],
            ['nombre' => 'editar_pagos', 'descripcion' => 'Editar pagos', 'modulo' => 'caja'],
            ['nombre' => 'eliminar_pagos', 'descripcion' => 'Eliminar pagos', 'modulo' => 'caja'],

            // Módulo: Pagos
            ['nombre' => 'ver_pagos', 'descripcion' => 'Ver listado de pagos', 'modulo' => 'pagos'],
            ['nombre' => 'crear_pagos', 'descripcion' => 'Crear pagos', 'modulo' => 'pagos'],
            ['nombre' => 'actualizar_pagos', 'descripcion' => 'Actualizar pagos', 'modulo' => 'pagos'],

            // Módulo: Reportes
            ['nombre' => 'ver_reportes', 'descripcion' => 'Ver todos los reportes', 'modulo' => 'reportes'],
            ['nombre' => 'generar_reporte_ventas', 'descripcion' => 'Generar reportes de ventas', 'modulo' => 'reportes'],
            ['nombre' => 'generar_reporte_compras', 'descripcion' => 'Generar reportes de compras', 'modulo' => 'reportes'],
            ['nombre' => 'ver_historial_ventas', 'descripcion' => 'Ver historial completo de ventas', 'modulo' => 'reportes'],
            ['nombre' => 'exportar_reportes_pdf', 'descripcion' => 'Exportar reportes a PDF', 'modulo' => 'reportes'],

            // Módulo: Auditoría
            ['nombre' => 'ver_auditoria', 'descripcion' => 'Ver auditoría de usuarios', 'modulo' => 'auditoria'],
            ['nombre' => 'eliminar_auditoria', 'descripcion' => 'Eliminar registros de auditoría', 'modulo' => 'auditoria'],
            ['nombre' => 'eliminar_toda_auditoria', 'descripcion' => 'Eliminar toda la auditoría', 'modulo' => 'auditoria'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::create($permiso);
        }

        $this->command->info('✅ Permisos creados exitosamente.');
        $this->command->info('Total de permisos: ' . count($permisos));
    }
}