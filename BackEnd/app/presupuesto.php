<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presupuesto extends Model
{
    //
    protected $table = 'presupuesto';

    public function Detalles()
    {
        return $this->hasMany('App\presupuestoDetalles', 'id_presupuesto', 'id');
    }

    public function cliente()
    {
        return $this->hasOne('App\clientes', 'id', 'id_cliente')->select('descripcion', 'id');;
    }

    public function campania()
    {
        return $this->hasOne('App\campania', 'id', 'id_campania')->select('descripcion', 'id');;
    }
}
