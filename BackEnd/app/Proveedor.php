<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
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
        'tipo_proveedor_id',
        'nombre_comercial'
    ];

    public function orden()
    {
        return $this->belongsTo('App\ordenCompra', 'id_proveedor');
    }

    public function tipoProveedor()
    {
        return $this->belongsTo('App\tipoProveedor');
    }

    public function datosInstalacion()
    {
        return $this->hasOne('App\instaladores', 'id_proveedor', 'id');
    }
}
