@extends('plantillas.autenticacion')

@section('titulo', 'Registro')

@section('h2','Crear Cuenta')

@section('contenido')
<form method="POST" action="{{ route('registrar') }}">
    @csrf

    <div class="form-group">
        <label for="nombre">Nombre Completo</label>
        <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus>
        @error('nombre')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="apellido">Apellido Completo</label>
        <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" required>
        @error('apellido')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <input id="password" type="password" name="password" required>
        @error('password')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirmar Contraseña</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
        @error('password_confirmation')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="direccion">Dirección</label>
        <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" >
        @error('direccion')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" >
        @error('telefono')
            <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn">Registrarse</button>
</form>

<div class="extra-links">
    <p>¿Ya tienes cuenta? <a href="{{ route('acceso') }}">Inicia sesión aquí</a></p>
</div>
@endsection
