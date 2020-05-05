<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entidadFederativa extends Model
{
    protected $table = 'estados';
    protected $fillable = [
        'descripcion',
    ];
    public $timestamps = false;
}
