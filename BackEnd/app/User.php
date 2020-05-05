<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_tipo_usuario', 'activo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function tipoUsuario()
    {
        return $this->hasOne('App\tipoUsuario', 'id', 'id_tipo_usuario')->select('descripcion', 'id');;
    }

    public function ordenCrea()
    {
        return $this->belongsTo('App\ordenCompra','id_usuario_crea');
    }

    public function ordenAutoriza()
    {
        return $this->belongsTo('App\ordenCompra','id_usuario_autoriza');
    }
}
