<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unidadesAutobus extends Model
{
    protected $table = 'unidades';
    protected $fillable = [
        'proveedor_id',
        'num_economico',
        'carroceria',
        'placas',
        'costo_renta_mensual',
        'activo'
    ];

    public function proveedor()
    {
        return $this->hasOne('App\Proveedor', 'id', 'proveedor_id')->select('descripcion', 'id');;
    }
}
