<?php

namespace App\Http\Controllers;
use DB;
use App\User;

use Illuminate\Http\Request;

class UsuariosController extends Controller
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
        return User::with('tipoUsuario')->get();
    }

    public function filterUsers(Request $request)
    {
        $whBuilder = array();
        $id_tipo_usuario = "";
        $conlogin = "";
        if ($request->has('TipoUsuario'))
        {
            $id_tipo_usuario = filter_var($request->input('TipoUsuario'), FILTER_SANITIZE_STRING);
            if (strlen($id_tipo_usuario) >= 1)
            {
                array_push($whBuilder, array('id_tipo_usuario', '=', $id_tipo_usuario));
            }
        }

        if ($request->has('ConLogin'))
        {
            $conlogin = filter_var($request->input('ConLogin'), FILTER_SANITIZE_STRING);
            if ($conlogin == '1')
            {
                array_push($whBuilder, array('activo', '=', 1));
            }
        }
        $u = User::where($whBuilder)->get();
        return response()->json($u, 200);
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
        // $usr = User::create($request->input('Usuario'));
        // return response()->json($usr, 201);
        $pwd = base64_decode(strtr($request->input('Usuario.password'), ' ', '+'));
        $pwd_val = base64_decode(strtr($request->input('Usuario.checkPassword'), ' ', '+'));
        if (strcmp($pwd, $pwd_val) === 0) {
            $user = User::create([
                'name' => $request->input('Usuario.name'),
                'email' => $request->input('Usuario.email'),
                'password' => bcrypt($pwd),
                'id_tipo_usuario' => $request->input('Usuario.id_tipo_usuario'),
                'activo' => $request->input('Usuario.activo') ? '1' : '0',
            ]);
            return response()->json($user, 201);
        } else {
            $result["error"] = 1;
            $result["message"] = "Las contraseñas no coinciden";
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('tipoUsuario')->find($id);
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
            $userData = User::find($id);
            $userData->fill($request->input('Usuario.usuario'));
            $userData->save();
            // $pwd = base64_decode(strtr($request->input('Usuario.password'), ' ', '+'));
            // $pwd_val = base64_decode(strtr($request->input('Usuario.checkPassword'), ' ', '+'));
            // $userData['id'] = $id;
            //$userData['name'] = $request->input('Usuario.usuario.name');
            //$userData['email'] = $request->input('Usuario.usuario.email');
            //$userData['id_tipo_usuario'] = $request->input('Usuario.usuario.id_tipo_usuario');
            //$userData['activo'] = $request->input('Usuario.usuario.activo');
            //User::where('id', $id)->update([$userData]);
        }
        /*
        $userData = [
            'name' => $request->input('Usuario.usuario.name'),
            'email' => $request->input('Usuario.usuario.email'),
            'password' => bcrypt($pwd),
            'id_tipo_usuario' => $request->input('Usuario.usuario.id_tipo_usuario'),
            'activo' => $request->input('Usuario.usuario.activo',
        ];
        */
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
