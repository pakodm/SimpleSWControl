<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rutas extends Model
{
    protected $fillable = [
        'clave',
        'nombre_ruta',
        'estado_id',
        'descripcion_ruta',
        'ruta_inicio',
        'latitud_inicio',
        'longitud_inicio',
        'ruta_fin',
        'latitud_fin',
        'longitud_fin',
        'disponible'
    ];
}
