<?php

namespace App\Http\Controladores\Autenticacion;

use App\Http\Controladores\Controlador;
use App\Modelos\Usuario;
use App\Modelos\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroControlador extends Controlador
{
    // Mostrar formulario
    public function mostrarFormularioDeRegistro()
    {
        return view('autenticacion.registro');
    }

    // Procesar registro
    public function registrar(Request $request)
{
    $request->validate([
        'nombre'    => ['required', 'string', 'max:150'],
        'apellido'  => ['required', 'string', 'max:150'],
        'email'     => ['required', 'email', 'unique:usuarios,email'],
        'password'  => ['required', 'confirmed', 'min:6'],
        'direccion' => ['nullable', 'string', 'max:255'],
        'telefono'  => ['nullable', 'string', 'max:20'],
    ]);

    // Crear usuario primero
    $usuario = Usuario::create([
        'nombre'      => $request->nombre . ' ' . $request->apellido,
        'email'       => $request->email,
        'contrasenia' => $request->password, // ya cifrada con pgcrypto
        'idrols'      => 2, // rol de cliente
    ]);

    // Crear cliente apuntando al usuario
    $cliente = Cliente::create([
        'idusuarios' => $usuario->id,
        'nombre'      => $request->nombre . ' ' . $request->apellido,
        'direccion'  => $request->direccion,
        'telefono'   => $request->telefono,
    ]);

    // Loguear usuario
    Auth::login($usuario);

    // Redirigir según rol
    $rol = Auth::user()->idrols;
    if ($rol === 1) {
        return redirect()->route('bienvenido.usuarios.vendedor'); 
    }

    return redirect()->intended('/');
}

}
