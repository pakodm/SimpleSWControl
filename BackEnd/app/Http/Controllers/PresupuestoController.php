<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\presupuesto;
use App\presupuestoDetalles;
use DB;
use DateTime;

class PresupuestoController extends Controller
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
    public function index(Request $request)
    {
        if ($request->has('simple')) {
            if ($request->input('simple') === '1') {
                $response = $this->listaPresupuestos();
            } else {
                $response = presupuesto::with('cliente')->get();
            }
            return response()->json($response, 200);
        } else {
            return presupuesto::with('cliente')->with('campania')->get();
        }
    }

    public function listaPresupuestos()
    {
        $listaPresupuesto = DB::table('presupuesto')
        ->join('clientes', 'presupuesto.id_cliente', '=', 'clientes.id')
        ->select(DB::raw('presupuesto.id as id, CONCAT(presupuesto.folio, " - ", clientes.descripcion) as descripcion'))
        // ->where('disponible', '=', 1)
        ->orderBy('clientes.descripcion')
        ->get();
        return $listaPresupuesto;
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
        $date = new DateTime($request->input('Presupuesto.fecha_inicio'));
        $presup = new presupuesto;
        $presup->id_cliente = $request->input('Presupuesto.id_cliente');
        $presup->id_campania = $request->input('Presupuesto.id_campania');
        $presup->nombre_publicidad = $request->input('Presupuesto.nombre_publicidad');
        $presup->duracion = $request->input('Presupuesto.duracion');
        $presup->tipo_duracion = $request->input('Presupuesto.tipo_duracion');
        $presup->fecha_inicio = $date->format('Y-m-d H:i:s');
        $presup->folio = $request->input('Presupuesto.folio');
        $presup->total_inversion = $request->input('Presupuesto.total_inversion');
        $presup->id_usuario = $currentUser;
        $presup->save();
        if ($presup->id > 0)
        {
            for ($i = 0; $i < count($request->input('Presupuesto.Detalles')); $i++)
            {
                $prDet = new presupuestoDetalles;
                $prDet->id_presupuesto = $presup->id;
                $prDet->id_tipo_medio = $request->input('Presupuesto.Detalles')[$i]['id_tipo_medio'];
                $prDet->cantidad = $request->input('Presupuesto.Detalles')[$i]['cantidad'];
                $prDet->costo_total = $request->input('Presupuesto.Detalles')[$i]['costo_total'];
                $prDet->id_usuario_modifico = $currentUser;
                $prDet->borrado = 0;
                $prDet->save();
            }
            /*
            for ($i = 0; $i < count($request->input('PreCosteo.Detalles')); $i++)
            {
                $prDet = new presupuestoDetalles;
                $prDet->id_presupuesto = $presup->id;
                $prDet->carroceria = $request->input('PreCosteo.Detalles')[$i]['carroceria'];
                $prDet->comision_ejecutivo = $request->input('PreCosteo.Detalles')[$i]['comision_ejecutivo'];
                $prDet->comisiones_externas = $request->input('PreCosteo.Detalles')[$i]['comisiones_externas'];
                $prDet->costo_instalacion = $request->input('PreCosteo.Detalles')[$i]['costo_instalacion'];
                $prDet->costo_m2 = $request->input('PreCosteo.Detalles')[$i]['costo_m2'];
                $prDet->costo_renta_mensual = $request->input('PreCosteo.Detalles')[$i]['costo_renta_mensual'];
                $prDet->costo_retiro = $request->input('PreCosteo.Detalles')[$i]['costo_retiro'];
                $prDet->entidad_fed = $request->input('PreCosteo.Detalles')[$i]['entidad_fed'];
                $prDet->factor_merma = $request->input('PreCosteo.Detalles')[$i]['factor_merma'];
                // $prDet->fecha_instalacion = $request->input('PreCosteo.Detalles')[$i]['carroceria'];
                // $prDet->fecha_pago_instalacion = $request->input('PreCosteo.Detalles')[$i]['carroceria'];
                $prDet->gasto_envios = $request->input('PreCosteo.Detalles')[$i]['gasto_envios'];
                $prDet->id_impresor = $request->input('PreCosteo.Detalles')[$i]['id_impresor'];
                $prDet->id_instalador = $request->input('PreCosteo.Detalles')[$i]['id_instalador'];
                $prDet->id_permisionario = $request->input('PreCosteo.Detalles')[$i]['id_permisionario'];
                $prDet->id_ruta = $request->input('PreCosteo.Detalles')[$i]['id_ruta'];
                $prDet->id_tipo_material = $request->input('PreCosteo.Detalles')[$i]['id_tipo_material'];
                $prDet->metros_por_unidad = $request->input('PreCosteo.Detalles')[$i]['metros_por_unidad'];
                $prDet->num_economico = $request->input('PreCosteo.Detalles')[$i]['num_economico'];
                $prDet->placas = $request->input('PreCosteo.Detalles')[$i]['placas'];
                $prDet->precio_renta_mensual = $request->input('PreCosteo.Detalles')[$i]['precio_renta_mensual'];
                $prDet->reparaciones = $request->input('PreCosteo.Detalles')[$i]['reparaciones'];
                $prDet->tipo_medio = $request->input('PreCosteo.Detalles')[$i]['tipo_medio'];
                $prDet->save();
            }
            */
        }
        return response()->json($presup, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presup = presupuesto::with('Detalles')->find($id);
        $myView = $presup;
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
        $presupuesto = presupuesto::findOrFail($id);
        $date = new DateTime($request->input('Presupuesto.fecha_inicio'));
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
            $presup = presupuesto::find($id);
            $presup->delete();
        }
    }
}
