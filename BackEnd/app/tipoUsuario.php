<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoUsuario extends Model
{
    protected $table = 'tipo_usuario';
    protected $fillable = [
        'descripcion',
        'activo'
    ];
    public $timestamps = false;

    public function usuarios()
    {
        return $this->hasMany('App\User');
    }
}
