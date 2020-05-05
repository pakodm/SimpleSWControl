<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presupuestoDetalles extends Model
{
    protected $table = 'presupuesto_detalle';

    public function presupuesto()
    {
        return $this->belongsTo('App\presupuesto', 'id', 'id_presupuesto');
    }

    public function tipoMedio()
    {
        return $this->hasOne('App\tipo_medio', 'id', 'id_tipo_medio')->select('descripcion', 'id');
    }

    public function precosteo()
    {
        return $this->hasMany('App\precosteo', 'id_presupuesto_detalle', 'id');
    }
}
