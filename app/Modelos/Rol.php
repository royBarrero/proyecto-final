<?php

namespace App\Modelos;


use Illuminate\Database\Eloquent\Model;

use App\Modelos\Usuario;
class Rol extends Model
{
    protected $table = 'rols';   // 👈 tu tabla
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['descripcion'];
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idrols');
    }

}
