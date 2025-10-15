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
            'email'     => ['required', 'email', 'unique:usuarios,email'], // validación única en la columna correo
            'password'  => ['required', 'confirmed', 'min:6'], // confirmado
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono'  => ['nullable', 'string', 'max:20'],
        ]);
        $cliente = Cliente::create([
            'nombre'    => $request->nombre . ' ' . $request->apellido,
            'direccion' => $request->direccion,
            'telefono'  => $request->telefono,
        ]);
        $usuario = Usuario::create([
            'nombre'      => $request->nombre . ' ' . $request->apellido, // concatenar nombre y apellido
            'email'      => $request->email,
            'contrasenia' => $request->password,
            'idclientes'  => $cliente->id
        ]);
    
        Auth::login($usuario);

        $rol = Auth::user()->idrols;   // gracias a la relación belongsTo
        if($rol === 1){
           return redirect()->route('bienvenido.usuarios.vendedor'); 
        }
        return redirect()->intended('/');
}

}
