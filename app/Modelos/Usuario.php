<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Modelos\Vendedor;
use App\Modelos\Cliente;
use App\Modelos\Rol;
use App\Modelos\Caja;
use App\Traits\TienePermisos;  // 👈 AGREGAR ESTA LÍNEA

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, TienePermisos;  // 👈 AGREGAR TienePermisos

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'contrasenia',
        'idrols',
        'idvendedors',
        'idclientes',
    ];

    protected $hidden = [
        'contrasenia',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'idusuarios');
    }

    public function vendedor()
    {
        return $this->hasOne(Vendedor::class, 'idusuarios');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idrols');
    }

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    public function cajas(): HasMany
    {
        return $this->hasMany(Caja::class, 'idusuarios');
    }

    public static function validarCredenciales(string $email, string $contrasenia): int
    {
        $resultado = DB::selectOne(
            "SELECT es_contrasenia_correcta(?, ?) AS estado",
            [$email, $contrasenia]
        );

        return $resultado->estado ?? 0;
    }

    public static function obtenerUsuariosCompleto()
    {
        return collect(DB::select('SELECT * FROM obtener_usuarios_completo()'))
        ->map(fn($u) => (object) $u);
    }

    public static function eliminarPorId(int $id): void
    {
        DB::statement('CALL eliminar_usuario_por_id(?)', [$id]);
    }

    public static function obtenerUsuario($id)
    {
        return DB::selectOne("SELECT * FROM obtener_usuario_por_id(?)", [$id]);
    }

    public static function actualizarUsuarioCompleto($id, $nombre, $email, $idrols, $direccion = null, $telefono = null): void
    {
        DB::statement(
            "CALL actualizar_usuario_completo(?, ?, ?, ?, ?, ?)",
            [$id, $nombre, $email, $idrols, $direccion, $telefono]
        );
    }
}