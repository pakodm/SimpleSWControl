<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\campania;
use DateTime;

class CampaniaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return campania::with('tipoMedio')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $f_inicio = new DateTime($request->input('Campania.fecha_inicio'));
        $f_fin = new DateTime($request->input('Campania.fecha_fin'));
        $c = new campania;
        $c->descripcion = $request->input('Campania.descripcion');
        $c->id_tipo_medio = $request->input('Campania.id_tipo_medio');
        $c->fecha_inicio = $f_inicio->format('Y-m-d H:i:s');
        $c->fecha_fin = $f_fin->format('Y-m-d H:i:s');
        $c->save();
        return response()->json($c, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $c = campania::find($id);
        return response()->json($c, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($id != null)
        {
            $f_inicio = new DateTime($request->input('Campania.fecha_inicio'));
            $f_fin = new DateTime($request->input('Campania.fecha_fin'));
            $c = campania::where('id', $id);
            if ($c != null) {
                $campania = [
                    'descripcion' => $request->input('Campania.descripcion'),
                    'id_tipo_medio' => $request->input('Campania.id_tipo_medio'),
                    'fecha_inicio' => $f_inicio->format('Y-m-d H:i:s'),
                    'fecha_fin' => $f_fin->format('Y-m-d H:i:s'),
                ];
                $c = campania::where('id', $id)->update($campania);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
