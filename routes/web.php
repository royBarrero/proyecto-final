<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controladores\Autenticacion\AccesoControlador;
use App\Http\Controladores\Autenticacion\RegistroControlador;
use App\Http\Controladores\Autenticacion\OlvideMiContraseniaControlador;
use App\Http\Controladores\Autenticacion\RestablecerContraseniaControlador;
use App\Http\Controladores\Autenticacion\PerfilControlador;
use App\Http\Controladores\UsuarioControlador;
use App\Http\Controladores\CategoriaControlador;
use App\Http\Controladores\RolControlador;
use App\Http\Controladores\ProductoAveControlador;
use App\Http\Controladores\FotoaveControlador;
use App\Http\Controladores\DetalleaveControlador;
use App\Http\Controladores\AuditoriaControlador;
use App\Http\Controladores\ProveedorControlador;
use App\Http\Controladores\PagoControlador;
use App\Http\Controladores\VentaControlador;
use App\Http\Controladores\CajaControlador;
use App\Http\Controladores\CompraControlador;
use App\Http\Controladores\ReporteCompraControlador;
use App\Http\Controladores\ReporteVentaControlador;
use App\Http\Controladores\ReporteHistorialVentaControlador;
use App\Http\Controladores\ProductoDisponibleControlador;
use App\Http\Controladores\MetodoPagoControlador;


Route::get('/', [FotoaveControlador::class, 'index'])->name("inicio");

/* ---------------- LOGIN ---------------- */
Route::get('/login', [AccesoControlador::class, 'mostrarFormularioDeAcceso'])->name('acceso');
Route::post('/login', [AccesoControlador::class, 'validarAcceso'])->name('validarAcceso');
Route::post('/logout', [AccesoControlador::class, 'cerrarSesion'])->name('cerrarSesion');

/* ---------------- REGISTER ---------------- */
Route::get('/register', [RegistroControlador::class, 'mostrarFormularioDeRegistro'])->name('registro');
Route::post('/register', [RegistroControlador::class, 'registrar'])->name('registrar');

/* ---------------- RECUPERAR CONTRASEÑA ---------------- */
// 1. Mostrar formulario para enviar email
Route::get('/forgot-password', [OlvideMiContraseniaControlador::class, 'mostrarFormularioDeSolicitudDeEnlace'])
    ->name('recuperar.contrasenia');

// 2. Enviar email con enlace
Route::post('/forgot-password', [OlvideMiContraseniaControlador::class, 'enviarEnlaceDeRestablecerCorreoElectronico'])
    ->name('recuperar.contrasenia.enviar');

// 3. Mostrar formulario para cambiar contraseña
Route::get('/reset-password/{token}', [RestablecerContraseniaControlador::class, 'mostrarFormularioDeReinicio'])
    ->name('reiniciar.contrasenia');

// 4. Guardar nueva contraseña
Route::post('/reset-password', [RestablecerContraseniaControlador::class, 'guardarNuevaContrasenia'])
    ->name('actualizar.contrasenia');

Route::get('/perfil', [PerfilControlador::class, 'verDatos'])->name('perfil')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/bienvenido', [UsuarioControlador::class, 'bienvenido'])->name('bienvenido.usuarios.vendedor');
    Route::get('/datos-personales', [UsuarioControlador::class, 'mostrarDatosPersonales'])->name('mostrarDatosPersonales');
    Route::get('/lista-de-usuarios', [UsuarioControlador::class, 'mostrarDatosDeTodosLosUsuarios'])->name('mostrarDatosDeTodosLosUsuarios');
    Route::post('/usuarios', [UsuarioControlador::class, 'guardar'])->name('guardar.usuarios');
    Route::get('/usuarios/{id}/editar', [UsuarioControlador::class, 'editarUsuario'])->name('editar.usuario');
    Route::put('/usuarios/{id}', [UsuarioControlador::class, 'actualizarUsuario'])->name('actualizarUsuario');
    Route::delete('/usuarios/{id}', [UsuarioControlador::class, 'eliminarUsuario'])->name('eliminar.usuario');
    Route::get('/formulario', [UsuarioControlador::class, 'formularioParaCrearNuevoUsuario'])->name('formularioParaCrearNuevoUsuario');

    Route::post('/usuarios/crear', [UsuarioControlador::class, 'crearNuevoUsuario'])->name('crearNuevoUsuario');
});



Route::resource('categorias', CategoriaControlador::class)->middleware('auth');

Route::resource('rols', RolControlador::class)->middleware('auth');

// Después de: Route::resource('rols', RolControlador::class)->middleware('auth');

// Agregar estas líneas para gestión de permisos:
Route::middleware('auth')->group(function () {
    Route::get('rols/{rol}/permisos', [RolControlador::class, 'gestionarPermisos'])
        ->name('rols.gestionarPermisos');
    
    Route::post('rols/{rol}/permisos', [RolControlador::class, 'actualizarPermisos'])
        ->name('rols.actualizarPermisos');
});

Route::resource('productoaves', ProductoAveControlador::class)->middleware('auth');

Route::resource('fotoaves', FotoaveControlador::class)->middleware('auth');

Route::resource('detalleaves', DetalleaveControlador::class)->middleware('auth');

Route::get('auditorias', [AuditoriaControlador::class, 'index'])->name('auditorias.index');
Route::delete('auditorias/{id}', [AuditoriaControlador::class, 'destroy'])->name('auditorias.destroy');
Route::delete('auditorias/destroyAll', [AuditoriaControlador::class, 'destroyAll'])->name('auditorias.destroyAll');

Route::resource('proveedores', ProveedorControlador::class);
Route::resource('pagos', PagoControlador::class);

Route::resource('ventas', VentaControlador::class);
// Después de: Route::resource('ventas', VentaControlador::class);
Route::get('ventas/exportar/pdf', [VentaControlador::class, 'exportarPDF'])->name('ventas.exportar.pdf');
Route::get('ventas/exportar/excel', [VentaControlador::class, 'exportarExcel'])->name('ventas.exportar.excel');
Route::resource('compras', CompraControlador::class);
Route::get('/compras', [App\Http\Controladores\CompraControlador::class, 'index'])->name('compras.index');

// Exportar compras
Route::get('compras/exportar/pdf', [CompraControlador::class, 'exportarPDF'])->name('compras.exportar.pdf');
Route::get('compras/exportar/excel', [CompraControlador::class, 'exportarExcel'])->name('compras.exportar.excel');

//RUTA DE REPORTE DE COMPRAS 
Route::middleware('auth')->group(function () {
    Route::get('/reporte-compras', [ReporteCompraControlador::class, 'index'])->name('reporte.compras');
    Route::get('/reporte-compras/pdf', [ReporteCompraControlador::class, 'exportarPDF'])->name('reporte.compras.pdf');
});
// GENERAR REPORTE DE VENTAS 
Route::prefix('reportes')->middleware('auth')->group(function() {
    Route::get('ventas', [ReporteVentaControlador::class, 'index'])->name('reportes.ventas.index');
    Route::get('ventas/pdf', [ReporteVentaControlador::class, 'generar'])->name('reportes.ventas.generar');
});
//GENERAR HISTORIAL DE REPORTE DE VENTAS 
// Rutas de historial de ventas
Route::prefix('reportes')->middleware('auth')->group(function() {
    Route::get('historial', [ReporteHistorialVentaControlador::class, 'index'])->name('reportes.historial.index');
    Route::get('historial/pdf', [ReporteHistorialVentaControlador::class, 'generar'])->name('reportes.historial.generar');
});
//GESTIONAR LISTA DE PRODUCTOS DISPONIBLES
Route::prefix('reportes')->middleware('auth')->group(function() {
    // Lista de productos disponibles
    Route::get('productos-disponibles', [ProductoDisponibleControlador::class, 'index'])
        ->name('reportes.productos.disponibles');
});
Route::middleware(['auth'])->group(function() {
    Route::get('/caja', [CajaControlador::class,'index'])->name('caja.index');

    Route::get('/caja/abrir', fn() => view('administracionDEfinanzas.gestionarCaja.abrir'))->name('caja.abrir.form');
    Route::post('/caja/abrir', [CajaControlador::class,'abrir'])->name('caja.abrir');

    Route::get('/caja/{id}/pagos', [CajaControlador::class,'formPago'])->name('caja.pagos.form');
    Route::post('/caja/pagos', [CajaControlador::class,'registrarPago'])->name('caja.pagos.store');

    Route::get('/caja/{id}/movimientos', [CajaControlador::class,'movimientos'])->name('caja.movimientos');
    Route::put('/caja/{id}/cerrar', [CajaControlador::class,'cerrar'])->name('caja.cerrar');
    
    Route::get('/pagos/{id}/editar', [CajaControlador::class, 'editarPago'])->name('pagos.edit');
    Route::put('/pagos/{id}', [CajaControlador::class, 'actualizarPago'])->name('pagos.update');
    Route::delete('/pagos/{id}', [CajaControlador::class, 'eliminarPago'])->name('pagos.destroy');

});
// Métodos de Pago (Administrador y Vendedor)
Route::middleware(['auth'])->group(function () {
    Route::resource('metodopagos', MetodoPagoControlador::class);
});
