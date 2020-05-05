<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $fillable = [
        'descripcion',
        'razon_social',
        'rfc',
        'calle',
        'num_extrior',
        'num_interior',
        'colonia',
        'ciudad',
        'estado',
        'cp',
        'correo_electronico'
    ];

    public function orden()
    {
        return $this->belongsTo('App\ordenCompra','id_empresa');
    }
}
