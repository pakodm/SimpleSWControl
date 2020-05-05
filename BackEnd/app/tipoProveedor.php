<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoProveedor extends Model
{
    protected $table = 'tipo_proveedor';
    protected $fillable = [
        'descripcion',
        'activo'
    ];
    public $timestamps = false;

    public function proveedores()
    {
        return $this->hasMany('App\Proveedor');
    }
}
