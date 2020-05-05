<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\precosteo;
use App\presupuestoDetalles;
use DB;
use DateTime;

class PrecosteoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     * 00740461009829636989 - 60000
     * 2439 - 5547425657
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 55 38 96 06 20
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
        $idDetallePresupuesto = $request->input('PreCosteo.id_detalle');
        $totalAGuardar = count($request->input('PreCosteo.Detalles'));
        $costoMedio = 0;
        $costoImpresion = 0;
        $costoInstalacion = 0;
        $costoOtros = 0;
        $costoTotal = 0;
        for ($i = 0; $i < count($request->input('PreCosteo.Detalles')); $i++)
        {
            $precosteo = new precosteo;
            $precosteo->id_presupuesto_detalle = $idDetallePresupuesto;
            $precosteo->carroceria = $request->input('PreCosteo.Detalles')[$i]['carroceria'];
            $precosteo->comision_ejecutivo = $request->input('PreCosteo.Detalles')[$i]['comision_ejecutivo'];
            $precosteo->comisiones_externas = $request->input('PreCosteo.Detalles')[$i]['comisiones_externas'];
            $precosteo->costo_instalacion = $request->input('PreCosteo.Detalles')[$i]['costo_instalacion'];
            $precosteo->costo_m2 = $request->input('PreCosteo.Detalles')[$i]['costo_m2'];
            $precosteo->costo_renta_mensual = $request->input('PreCosteo.Detalles')[$i]['costo_renta_mensual'];
            $precosteo->costo_retiro = $request->input('PreCosteo.Detalles')[$i]['costo_retiro'];
            $precosteo->entidad_fed = $request->input('PreCosteo.Detalles')[$i]['entidad_fed'];
            $precosteo->factor_merma = $request->input('PreCosteo.Detalles')[$i]['factor_merma'];
            // $precosteo->fecha_instalacion = $request->input('PreCosteo.Detalles')[$i]['carroceria'];
            // $precosteo->fecha_pago_instalacion = $request->input('PreCosteo.Detalles')[$i]['carroceria'];
            $precosteo->gasto_envios = $request->input('PreCosteo.Detalles')[$i]['gasto_envios'];
            $precosteo->id_impresor = $request->input('PreCosteo.Detalles')[$i]['id_impresor'];
            $precosteo->id_instalador = $request->input('PreCosteo.Detalles')[$i]['id_instalador'];
            $precosteo->id_permisionario = $request->input('PreCosteo.Detalles')[$i]['id_permisionario'];
            $precosteo->id_ruta = $request->input('PreCosteo.Detalles')[$i]['id_ruta'];
            $precosteo->id_tipo_material = $request->input('PreCosteo.Detalles')[$i]['id_tipo_material'];
            $precosteo->metros_por_unidad = $request->input('PreCosteo.Detalles')[$i]['metros_por_unidad'];
            $precosteo->num_economico = $request->input('PreCosteo.Detalles')[$i]['num_economico'];
            $precosteo->placas = $request->input('PreCosteo.Detalles')[$i]['placas'];
            $precosteo->precio_renta_mensual = $request->input('PreCosteo.Detalles')[$i]['precio_renta_mensual'];
            $precosteo->reparaciones = $request->input('PreCosteo.Detalles')[$i]['reparaciones'];
            $precosteo->tipo_medio = $request->input('PreCosteo.Detalles')[$i]['tipo_medio'];
            $costoMedio += $precosteo->costo_renta_mensual;
            $costoImpresion += ($precosteo->costo_m2 * $precosteo->metros_por_unidad);
            $costoInstalacion += ($precosteo->costo_instalacion + $precosteo->costo_retiro + $precosteo->reparaciones);
            $costoOtros += ($precosteo->gasto_envios + $precosteo->comision_ejecutivo + $precosteo->comisiones_externas);
            $precosteo->save();
            if ($precosteo->id != null && $precosteo->id > 0) {
                $totalAGuardar--;
            }
        }
        if (!is_numeric($costoMedio)) { $costoMedio = 0; }
        if (!is_numeric($costoImpresion)) { $costoImpresion = 0; }
        if (!is_numeric($costoInstalacion)) { $costoInstalacion = 0; }
        if (!is_numeric($costoOtros)) { $costoOtros = 0; }
        presupuestoDetalles::where('id', $idDetallePresupuesto)->update(array(
            'costo_medio' => $costoMedio,
            'costo_impresion' => $costoImpresion,
            'costo_instalacion' => $costoInstalacion,
            'costo_otros' => $costoOtros,
            'costo_total' => ($costoMedio + $costoImpresion + $costoInstalacion + $costoOtros)
        ));
        $response = [
            "status" => "OK",
            "isError" => $totalAGuardar
        ];
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoMedio = presupuestoDetalles::with('precosteo')->find($id);
        return response()->json($tipoMedio, 200);
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
        if ($id !== null) {
            $prec = precosteo::find($id);
            $prec->delete();
        }
    }
}
