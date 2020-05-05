<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordenCompraDetalle extends Model
{
    //
    protected $fillable = [
        'id_orden_compra',
        'id_campania',
        'id_tipo_medio',
        'id_plaza',
        'direccion_ruta',
        'periodo_medio',
        'vigencia_meses',
        'cantidad',
        'precio_unitario',
        'fecha_creacion'
    ];

    public function orden()
    {
        return $this->belongsTo('App\ordenCompra', 'id', 'id_orden_compra');
    }

    public function tipoMedio()
    {
        return $this->belongsTo('App\tipo_medio', 'id', 'id_tipo_medio');
    }

    public function nombreCampania()
    {
        return $this->belongsTo('App\campania', 'id', 'id_campania');
    }

    public function nombrePlaza()
    {
        return $this->belongsTo('App\plaza', 'id', 'id_plaza');
    }

    public $timestamps = false;
}
