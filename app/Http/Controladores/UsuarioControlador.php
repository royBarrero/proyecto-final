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
        return response()->view('vendedores.bienvenido')->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }
    public function mostrarDatosPersonales()
    {
        return response()->view('vendedores.bienvenido')->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }
    public function mostrarDatosDeTodosLosUsuarios()
    {
        $usuarios = Usuario::obtenerUsuariosCompleto();
        return response()->view('vendedores.mostrar-usuarios', compact('usuarios'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }
    public function formularioParaCrearNuevoUsuario()
    {
        $roles = Rol::all(); // obtenemos roles para el dropdown
        return response()->view('vendedores.crear-usuario', compact('roles'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
    }
public function crearNuevoUsuario(Request $request)
{
    // 1️⃣ Validar datos
    $request->validate([
        'nombre' => 'required|string|max:150',
        'email' => 'required|email|unique:usuarios,email',
        'contrasenia' => 'required|min:6',
        'idrols' => 'nullable|exists:rols,id',
        'direccion' => 'nullable|string|max:250',
        'telefono' => 'nullable|string|max:30',
    ]);

    // 2️⃣ Crear usuario nuevo
    $usuario = new Usuario();
    $usuario->nombre = $request->nombre;
    $usuario->email = $request->email;
    $usuario->contrasenia = $request->contrasenia; // TgCrypt lo maneja
    $usuario->idrols = $request->idrols ?? 2; // Por defecto cliente
    $usuario->save();

    // 3️⃣ Crear cliente o vendedor
    $rolDescripcion = $request->idrols 
        ? Rol::find($request->idrols)->descripcion ?? '' 
        : '';

    if (strtolower($rolDescripcion) === 'vendedor') {
        $vendedor = new Vendedor();
        $vendedor->idusuarios = $usuario->id;
        $vendedor->nombre = $request->nombre;
        $vendedor->direccion = $request->direccion ?: null;
        $vendedor->telefono = $request->telefono ?: null;
        $vendedor->email = $request->email;
        $vendedor->activo = 0; // inactivo
        $vendedor->save();
    } else {
        $cliente = new Cliente();
        $cliente->idusuarios = $usuario->id;
        $cliente->nombre = $request->nombre;
        $cliente->direccion = $request->direccion ?: null;
        $cliente->telefono = $request->telefono ?: null;
        $cliente->activo = 1; // activo
        $cliente->save();
    }

    // 4️⃣ Retornar la vista usando response()->view() con cache control
    return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('success', 'Usuario creado correctamente.');
}


    public function editarUsuario($id)
    {
        $usuario = Usuario::obtenerUsuario($id);
        $roles = Rol::all();
        $rolIdUsuario = null;
        // Recorremos los roles hasta encontrar el del usuario
        foreach ($roles as $rol) {
            if ($rol->descripcion == $usuario->rol) { // Asumiendo que $usuario->rol contiene el nombre del rol
             $rolIdUsuario = $rol->id;
            break; // Detiene el bucle cuando encuentra el rol
            }
        }
        
        return response()->view('vendedores.editar-usuario', compact('usuario','roles','rolIdUsuario'))
                         ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                         ->header('Pragma', 'no-cache')
                         ->header('Expires', '0');
    }

    public function actualizarUsuario(Request $request, $id)
    {
        //dd($request->all);
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

        return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('warning', 'Usuario actualizado correctamente.');
    }



public function eliminarUsuario($id)
{
    $usuario = Usuario::findOrFail($id);
    $usuario->delete();

    return redirect()->route('mostrarDatosDeTodosLosUsuarios')->with('error', 'Usuario eliminado correctamente.');
}
}
