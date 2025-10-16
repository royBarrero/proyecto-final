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

Route::get('/', function () {
    return view('bienvenido');
})->name("inicio");

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

Route::resource('productoAves', ProductoAveControlador::class)->middleware('auth');


