<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // Importante
use App\Observers\AuditoriaObserver;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use App\Modelos\Auditoria;

use Illuminate\Auth\Events\Failed;

use App\Modelos\Categoria;
use App\Modelos\Cliente;
use App\Modelos\Detalleave;
use App\Modelos\Fotoave;
use App\Modelos\Productoave;
use App\Modelos\Proveedor;
use App\Modelos\Rol;
use App\Modelos\Usuario;
use App\Modelos\Vendedor;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('componentes.alerta', 'alerta');
        // Observador para cambios en el modelo Usuario
        $models = [
        Usuario::class,
        Productoave::class,
        Cliente::class,
        Proveedor::class,
        Categoria::class,
        Detalleave::class,
        Fotoave::class,
        Rol::class,
        Vendedor::class,
    ];

    foreach ($models as $model) {
        $model::observe(AuditoriaObserver::class);
    }

        // Registrar inicio y cierre de sesión
        Event::listen(Login::class, function ($event) {
            Auditoria::create([
                'tabla' => 'usuarios',
                'registro_id' => $event->user->id ?? null,
                'accion' => 'INICIO_SESION',
                'usuario_id' => $event->user->id ?? null,
                'cambios' => ['nombre' => $event->user->nombre ?? 'Desconocido'],
                'ip' => Request::ip(),
            ]);
        });

        Event::listen(Logout::class, function ($event) {
            Auditoria::create([
                'tabla' => 'usuarios',
                'registro_id' => $event->user->id ?? null,
                'accion' => 'CIERRE_SESION',
                'usuario_id' => $event->user->id ?? null,
                'cambios' => ['nombre' => $event->user->nombre ?? 'Desconocido'],
                'ip' => Request::ip(),
            ]);
        });

        // Intento fallido de inicio de sesión
        Event::listen(Failed::class, function ($event) {
            Auditoria::create([
                'tabla' => 'usuarios',
                'registro_id' => null,
                'accion' => 'INTENTO_FALLIDO',
                'usuario_id' => null,
                'cambios' => [
                'correo' => $event->credentials['correo'] ?? $event->credentials['email'] ?? 'desconocido'],
                'ip' => Request::ip(),
            ]);
        });

    }
}
