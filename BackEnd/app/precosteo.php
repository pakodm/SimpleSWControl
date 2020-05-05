<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class precosteo extends Model
{
    protected $table = 'precosteo';

    public function detallesPresupuesto()
    {
        return $this->belongsTo('App\presupuesto_detalle', 'id', 'id_presupuesto_detalle');
    }
}
