<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;;
use Illuminate\Database\Eloquent\Model;
use App\Modelos\Fotoaves;
use App\Modelos\Detalleave;
use App\Modelos\Categoria;

class Productoave extends Model
{
    protected $table = 'productoaves';   // 👈 tu tabla
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'precio',
        'idcategorias',
        'iddetalleaves',
        'cantidad'
    ];
     // 🔗 Relación con FotoAve (1 producto puede tener muchas fotos)
    public function fotoAves()
    {
        return $this->hasMany(Fotoave::class, 'idproductoaves', 'id');
    }

    // 🔗 Relación con DetalleAve (1 producto pertenece a 1 detalle)
    public function detalleAve()
    {
        return $this->belongsTo(Detalleave::class, 'iddetalleaves', 'id');
    }

    // 🔗 Relación con Categoría (1 producto pertenece a 1 categoría)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcategorias', 'id');
    }
}
/*<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;;
use Illuminate\Database\Eloquent\Model;

class ProductoAve extends Model
{
    protected $table = 'productoAves';   // 👈 tu tabla
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'nombre',
        'precio',
        'idcategorias',
        'iddetalleAves'
    ];
    public function productoAves()
    {
        return $this->hasMany(Usuario::class, 'idrols');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcategorias');
    }
    public function detalleAve()
    {
        return $this->belongsTo(DetalleAve::class, 'idcategorias');
    }
}*/