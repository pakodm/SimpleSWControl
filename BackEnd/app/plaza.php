<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class plaza extends Model
{
    //
    protected $fillable = [
        'descripcion_corta',
        'descripcion'
    ];

    public function DetallesOC()
    {
        return $this->hasMany('App\ordenCompraDetalle', 'id_tipo_medio', 'id');
    }
}
