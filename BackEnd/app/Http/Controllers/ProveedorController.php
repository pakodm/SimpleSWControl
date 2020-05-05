<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Proveedor;
use App\instaladores;
use App\proveedorMaterial;

class ProveedorController extends Controller
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
        if ($request->has('lista')) {
            $ids = explode(',',filter_var($request->input('lista'), FILTER_SANITIZE_STRING));
            return Proveedor::find($ids);    
        } else {
            return Proveedor::with('tipoProveedor')->get();
        }
    }

    public function getProveedorById()
    {
        return Proveedor::find('[3,4,5]');
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
        $tipo_proveedor = $request->input('Proveedores.tipo_proveedor_id') * 1;
        $proveedor = Proveedor::create($request->input('Proveedores'));
        if ($proveedor->id > 0 && $tipo_proveedor === 3) {
            $inst = new instaladores;
            $inst->id_proveedor = $proveedor->id;
            $inst->costo_instalacion = $request->input('Proveedores.costo_instalacion');
            $inst->costo_retiro = $request->input('Proveedores.costo_retiro');
            $inst->save();
        }
        return response()->json($proveedor, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        $myView = [
            "Proveedor" => $proveedor,
        ];
        if (($proveedor->tipo_proveedor_id * 1) === 3)
        {
            $datosInst = Proveedor::find($id)->datosInstalacion;
            $myView["DatosInstalacion"] = $datosInst;
        }
        return response()->json($myView);
    }

    public function bytype($id)
    {
        $p = Proveedor::where('tipo_proveedor_id', $id)->get();
        return response()->json($p, 200);
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

    public function getTipoMaterial($id)
    {
        $proveedor = Proveedor::find($id);
        $listaMateriales = [
            "id" => $id
        ];
        if ($proveedor->id > 0) {
            $listaMateriales['Materiales'] = DB::table('proveedor_material')
                ->leftJoin('tipo_material', 'proveedor_material.tipo_material_id', '=', 'tipo_material.id')
                ->select('proveedor_material.costo_m2 as costo','tipo_material.id','tipo_material.descripcion_corta as descripcion')
                ->where('proveedor_material.proveedor_id', '=', ($id * 1))
                ->get();
        }
        return response()->json($listaMateriales, 200);
    }

    public function setTipoMaterial(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);
        $result = [];
        if (($proveedor->tipo_proveedor_id * 1) == 2) {
            $pm = new proveedorMaterial;
            $pm->proveedor_id = $proveedor->id;
            $pm->tipo_material_id = $request->input('Materiales.tipo_m_p_id') * 1;
            $pm->costo_m2 = $request->input('Materiales.extra_data') * 1;
            $pm->activo = 1;
            $pm->save();
            $result["ProveedorMaterial"] = $pm;

        } else {
            $result["error"] = 1;
            $result["message"] = "Proveedor Incorrecto";
        }
        return response()->json($result, 200);
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
        if ($id != null) {
            Proveedor::where('id', $id)->update($request->input('Proveedores'));
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
        if ($id != null) {
            $proveedor = Proveedor::find($id);
            $proveedor->delete();
        }
    }
}
