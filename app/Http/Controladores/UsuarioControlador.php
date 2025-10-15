<?php

namespace App\Http\Controladores;

use App\Http\Controladores\Controlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Modelos\Usuario;
use App\Modelos\Rol;
use App\Modelos\Vendedor;
use App\Modelos\Cliente;
class UsuarioControlador extends Controlador
{
    public function bienvenido()
    {
        return view('vendedores.bienvenido');
    }
    public function mostrarDatosPersonales()
    {
        return view('vendedores.bienvenido');
    }
    public function mostrarDatosDeTodosLosUsuarios()
    {
        $usuarios = Usuario::obtenerUsuariosCompleto();
        return view('vendedores.mostrar-usuarios', compact('usuarios'));
    }
    public function formularioParaCrearNuevoUsuario()
    {
        $roles = Rol::all(); // obtenemos roles para el dropdown
        return view('vendedores.crear-usuario', compact('roles'));
    }
    public function crearNuevoUsuario(Request $request)
    {
        // 1️⃣ Validar datos
        $request->validate([
            'nombre' => 'required|string|max:150',
            'email' => 'required|email|unique:usuarios,email',
            'contrasenia' => 'required|min:6',
            'idrols' => 'required|exists:rols,id',
            'direccion' => 'nullable|string|max:250',
            'telefono' => 'nullable|string|max:30',
        ]);
        // 2️⃣ Crear usuario nuevo
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->contrasenia = $request->contrasenia;
        $usuario->idrols = $request->idrols;
        
        
        // 3️⃣ Crear cliente o vendedor según rol
        $rolDescripcion = Rol::find($request->idrols)->descripcion ?? '';

        if (strtolower($rolDescripcion) === 'cliente') {
            $cliente = new Cliente();
            $cliente->nombre = $request->nombre;
            $cliente->direccion = $request->direccion ?: null;
            $cliente->telefono = $request->telefono ?: null;
            $cliente->save();

            $usuario->idclientes = $cliente->id;
            $usuario->save();

        } elseif (strtolower($rolDescripcion) === 'vendedor') {
            $vendedor = new Vendedor();
            $vendedor->nombre = $request->nombre;
            $vendedor->direccion = $request->direccion ?: null;
            $vendedor->telefono = $request->telefono ?: null;
            $vendedor->email = $request->email;
            $vendedor->save();

            $usuario->idvendedors = $vendedor->id;
            $usuario->save();
        }
        
    // 4️⃣ Redirigir con mensaje de éxito
    return redirect()->route('mostrarDatosDeTodosLosUsuarios')
                     ->with('success', 'Usuario creado correctamente.');
}

    public function editarUsuario($id)
    {
        $usuario = Usuario::obtenerUsuario($id);
        $roles = Rol::all();
        return view('vendedores.editar-usuario', compact('usuario','roles'));
    }

    public function actualizarUsuario(Request $request, $id)
    {
        // Validación
        $request->validate([
        'nombre'    => 'required|string|max:150',
        'email'     => 'required|email|unique:usuarios,email,' . $id,
        'idrols'    => 'required|exists:rols,id',
        'direccion' => 'nullable|string|max:250',
        'telefono'  => 'nullable|string|max:30',
        ]);

        // Llamar al procedimiento almacenado desde el modelo
        Usuario::actualizarUsuarioCompleto(
            $id,
            $request->nombre,
            $request->email,
            $request->idrols,
            $request->direccion,
            $request->telefono
        );

        return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('success', 'Usuario actualizado correctamente.');
    }



public function eliminarUsuario($id)
{
    $usuario = Usuario::findOrFail($id);
    $usuario->delete();

    return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('success', 'Usuario eliminado correctamente.');
}
}
