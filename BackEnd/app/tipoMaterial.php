<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoMaterial extends Model
{
    protected $table = 'tipo_material';
    protected $fillable = [
        'descripcion_corta',
        'descripcion',
        'precio_unitario',
        'activo',
        'id_usuario'
    ];
}
