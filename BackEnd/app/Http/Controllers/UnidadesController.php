<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\unidadesAutobus;

class UnidadesController extends Controller
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
        return unidadesAutobus::with('proveedor')->get();
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
        $unidad = unidadesAutobus::create($request->input('UTransporte'));
        return response()->json($unidad, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return unidadesAutobus::find($id);
    }

    public function getByNumEco($id_proveedor, $num_eco)
    {
        $u = unidadesAutobus::where([
            ['proveedor_id', '=', $id_proveedor],
            ['num_economico', '=', $num_eco],
        ])->get();
        return response()->json($u, 200);
    }

    public function getByPlaca(Request $request)
    {
        $whBuilder = array();
        $placa = "";
        $id_proveedor = "";
        if ($request->has('placa'))
        {
            $placa = filter_var($request->input('placa'), FILTER_SANITIZE_STRING);
            if (strlen($placa) >= 1)
            {
                array_push($whBuilder, array('placas', 'LIKE', "%{$placa}%"));
            }
        }

        if ($request->has('proveedor'))
        {
            $id_proveedor = filter_var($request->input('proveedor'), FILTER_SANITIZE_STRING);
            if (strlen($id_proveedor >= 1))
            {
                array_push($whBuilder, array('proveedor_id', '=', $id_proveedor));
            }
        }
        $u = unidadesAutobus::where($whBuilder)->get();
        return response()->json($u, 200);
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
            $u = unidadesAutobus::where('id', $id)->update($request->input('UTransporte'));
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
