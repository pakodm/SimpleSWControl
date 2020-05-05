<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_medio extends Model
{
    //
    protected $fillable = [
        'descripcion'
    ];

    public function DetallesOC()
    {
        return $this->hasMany('App\ordenCompraDetalle', 'id_tipo_medio', 'id');
    }
}
