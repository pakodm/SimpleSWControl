<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\rutas;
use App\Proveedor;

class RutasController extends Controller
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
        return rutas::get();
    }

    public function getSimple()
    {
        $listaRutas = DB::table('rutas')
            ->select(DB::raw('id, CONCAT(clave, " - ", nombre_ruta) as nombre_ruta'))
            ->where('disponible', '=', 1)
            ->get();
        return response()->json($listaRutas, 200);
    }

    public function getRutaProveedor($id)
    {
        $proveedor = Proveedor::find($id);
        $listaRutas = [
            "id" => $id
        ];
        if ($proveedor->id > 0) {
            $listaRutas['Rutas'] = DB::table('proveedor_ruta')
                ->leftJoin('rutas', 'proveedor_ruta.ruta_id', '=', 'rutas.id')
                ->select('rutas.*')
                ->where('proveedor_ruta.proveedor_id', '=', ($id * 1))
                ->get();
        }
        return response()->json($listaRutas, 200);
    }

    public function setRutaProveedor($id)
    {
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
        $ruta = rutas::create($request->input('Ruta'));
        return response()->json($ruta, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return rutas::find($id);
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
        if ($id != null)
        {
            $ruta = rutas::where('id', $id)->update($request->input('Ruta'));
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
        if ($id !== null)
        {
            $ruta = rutas::find($id);
            $ruta->delete();
        }
    }
}
