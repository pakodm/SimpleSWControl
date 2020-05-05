<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proveedorMaterial extends Model
{
    protected $table = 'proveedor_material';
    protected $fillable = [
        'proveedor_id',
        'tipo_material_id',
        'costo_m2',
        'activo'
    ];
    public $timestamps = false;

    public function tipoMaterial()
    {
        return $this->belongsTo('App\tipoMaterial');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
}
