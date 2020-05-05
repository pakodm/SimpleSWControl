<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;

class ordenCompra extends Model
{
    //
    protected $fillable = [
        'folio',
        'fecha_oc',
        'id_empresa',
        'id_proveedor',
        'observaciones',
        'subtotal',
        'total'
    ];

    public function Detalles()
    {
        return $this->hasMany('App\ordenCompraDetalle', 'id_orden_compra', 'id');
    }

    public function proveedor()
    {
        return $this->hasOne('App\Proveedor', 'id', 'id_proveedor')->select('descripcion', 'id');
    }

    public function nombreProveedor()
    {

        $p = Proveedor::where('id', $this->id_proveedor)->first(); //->descripcion;
        // error_log($this->id_proveedor);
        return $p;
    }

    public function empresa()
    {
        return $this->hasOne('App\empresa', 'id', 'id_empresa')->select('descripcion', 'id');;
    }

    public function usuarioCrea()
    {
        return $this->hasOne('App\User', 'id', 'id_usuario_crea');
    }

    public function usuarioAutoriza()
    {
        return $this->hasOne('App\User', 'id', 'id_usuario_autoriza');
    }

    public $timestamps = false;
}
