<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class instaladores extends Model
{
    protected $table = 'instaladores';
    protected $fillable = [
        'id_proveedor',
        'costo_instalacion',
        'costo_retiro'
    ];
    public $timestamps = false;

    public function getProveedor()
    {
        return $this->belongsTo('App\Proveedor', 'id', 'id_proveedor');
    }
}
