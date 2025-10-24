@extends('plantillas.autenticacion')

@section('titulo', 'Recuperar Contraseña')

@section('h2', 'Recuperar Contraseña')

@section('contenido')
    <form method="POST" action="{{ route('recuperar.contrasenia.enviar') }}">
        @csrf

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p style="color:red; font-size: 0.9em;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn">Enviar enlace de recuperación</button>
    </form>

    <div class="extra-links">
        <p><a href="{{ route('acceso') }}">Volver al inicio de sesión</a></p>
    </div>
@endsection
