<?php

namespace App\Http\Controladores\Autenticacion;

use App\Http\Controladores\Controlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modelos\Usuario;


class AccesoControlador extends Controlador
{
    // Mostrar formulario de login
    public function mostrarFormularioDeAcceso()
    {
        return view('autenticacion.acceso');
    }

    // Procesar login
    public function validarAcceso(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $estado = Usuario::validarCredenciales($request->email, $request->password);
        
        if ($estado === 0) {
            return back()->withErrors(['email' => 'El correo no existe.'])->withInput();
        }

        if ($estado === 1 ) {
            return back()->withErrors(['password' => 'La contraseña es incorrecta.'])->withInput();
        }

        // Login correcto
        $usuario = Usuario::where('email', $request->email)->first();
        Auth::login($usuario);
        $request->session()->regenerate();

        $rol = Auth::user()->idrols;   // gracias a la relación belongsTo
        if($rol === 1 || $rol === 3 ){
           return redirect()->route('bienvenido.usuarios.vendedor'); 
        }
        return redirect()->intended('/');

    }

    // Cerrar sesión
    public function cerrarSesion(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
