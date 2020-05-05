<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ordenCompra;
use App\ordenCompraDetalle;
use DateTime;

class OrdenCompraController extends Controller
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
        // return ordenCompra::with('detalles')->get();
        return ordenCompra::with('proveedor')->with('empresa')->get();
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
        $currentUser = auth()->user()->id;
        $ldate = date('Y-m-d H:i:s');
        $oc = new ordenCompra;
        $oc->folio = $request->input('OrdenCompra.Generales.folio');
        $date = new DateTime($request->input('OrdenCompra.Generales.fecha_oc'));
        $oc->fecha_oc = $date->format('Y-m-d H:i:s');
        $oc->id_empresa = $request->input('OrdenCompra.Generales.id_empresa');
        $oc->id_proveedor = $request->input('OrdenCompra.Generales.id_proveedor');
        $oc->observaciones = $request->input('OrdenCompra.Generales.observaciones', '');
        $oc->subtotal = $request->input('OrdenCompra.Generales.subtotal', 0.0);
        $oc->total = $request->input('OrdenCompra.Generales.total', 0.0);
        $oc->id_usuario_crea = $currentUser;
        $oc->fecha_creacion = "${ldate}";
        $oc->save();
        if ($oc->id > 0)
        {
            for ($i = 0; $i < count($request->input('OrdenCompra.Detalles')); $i++)
            {
                $od = new ordenCompraDetalle;
                $od->id_orden_compra = $oc->id;
                $od->id_campania = $request->input('OrdenCompra.Detalles')[$i]['id_campania'];
                $od->id_tipo_medio = $request->input('OrdenCompra.Detalles')[$i]['id_tipo_medio'];
                $od->id_plaza = $request->input('OrdenCompra.Detalles')[$i]['id_plaza'];
                $od->direccion_ruta = $request->input('OrdenCompra.Detalles')[$i]['direccion_ruta'];
                $od->periodo_medio = $request->input('OrdenCompra.Detalles')[$i]['periodo_medio'];
                $od->vigencia_meses = $request->input('OrdenCompra.Detalles')[$i]['vigencia_meses'];
                $od->cantidad = $request->input('OrdenCompra.Detalles')[$i]['cantidad'];
                $od->precio_unitario = $request->input('OrdenCompra.Detalles')[$i]['precio_unitario'];
                $od->fecha_creacion = "${ldate}";
                $od->save();
            }
        }
        return response()->json($oc, 201);
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
        $oc = ordenCompra::with('Detalles')->find($id);
        $myView = [
            "Generales" => [
                "id" => $oc->id,
                "folio" => $oc->folio,
                "fecha_oc" => $oc->fecha_oc,
                "id_proveedor" => $oc->id_proveedor,
                "id_empresa" => $oc->id_empresa,
                "observaciones" => $oc->observaciones,
                "subtotal" => $oc->subtotal,
                "total" => $oc->total
            ],
            "Detalles" => $oc->Detalles
        ];
        return response()->json($myView);
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
        if ($id != null) {
            $oc = ordenCompra::find($id);
            $oc->delete();
        }
    }
}
