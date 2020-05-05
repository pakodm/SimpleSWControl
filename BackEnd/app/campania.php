<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class campania extends Model
{
    //
    protected $fillable = [
        'descripcion',
        'id_tipo_medio',
        'fecha_inicio',
        'fecha_fin'
    ];

    public $timestamps = false;

    public function DetallesOC()
    {
        return $this->hasMany('App\ordenCompraDetalle', 'id_tipo_medio', 'id');
    }

    public function tipoMedio()
    {
        return $this->hasOne('App\tipo_medio', 'id', 'id_tipo_medio');
    }
}
