<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\precosteo;
use App\presupuesto;
use App\ordenCompra;

class HerramientasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getNextFolio($recurso)
    {
        $recurso = is_numeric($recurso) ? $recurso * 1 : 0;
        $nextID = 0;
        switch($recurso)
        {
            case 1: $nextID = presupuesto::max('id') + 1; break;
            case 2: $nextID = precosteo::max('id') + 1; break;
            case 3: $nextID = ordenCompra::max('id') + 1; break;
            default: $nextID = 0;
        }
        $response = [
            "status" => "OK",
            "isError" => 0,
            "Folio" => sprintf("%05d", $nextID)
        ];
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
