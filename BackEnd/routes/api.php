<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('register', 'AuthController@register');
Route::get('status', 'AuthController@status');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::post('me', 'AuthController@me');

// Proveedores
Route::get('proveedores', 'ProveedorController@index');
Route::get('proveedores/{id}', 'ProveedorController@show');
Route::post('proveedores', 'ProveedorController@store');
Route::put('proveedores/{id}', 'ProveedorController@update');
Route::delete('proveedores/{id}', 'ProveedorController@destroy');
Route::get('proveedores/tipo/{id}', 'ProveedorController@bytype');
Route::get('proveedores/{id}/tipomaterial', 'ProveedorController@getTipoMaterial');
Route::post('proveedores/{id}/tipomaterial', 'ProveedorController@setTipoMaterial');

// Orden de Compra
Route::get('ordenescompra', 'OrdenCompraController@index');
Route::get('ordenescompra/{id}', 'OrdenCompraController@show');
Route::post('ordenescompra', 'OrdenCompraController@store');
Route::put('ordenescompra/{id}', 'OrdenCompraController@update');
Route::delete('ordenescompra/{id}', 'OrdenCompraController@destroy');

// Oden Detalles
Route::get('ordenescompra/detalles', 'OrdenDetallesController@index');
Route::get('ordenescompra/detalles/{id}', 'OrdenDetallesController@show');
Route::post('ordenescompra/detalles', 'OrdenDetallesController@store');

// Presupuesto
Route::get('presupuesto', 'PresupuestoController@index');
Route::get('presupuesto/{id}', 'PresupuestoController@show');
Route::post('presupuesto', 'PresupuestoController@store');
Route::put('presupuesto/{id}', 'PresupuestoController@update');
Route::delete('presupuesto/{id}', 'PresupuestoController@destroy');
Route::get('presupuesto/detalles/{id}', 'PresupuestoDetallesController@show');

// PreCosteo
Route::get('precosteo', 'PrecosteoController@index');
Route::get('precosteo/{id}', 'PrecosteoController@show');
Route::post('precosteo', 'PrecosteoController@store');
Route::put('precosteo/{id}', 'PrecosteoController@update');
Route::delete('precosteo/{id}', 'PrecosteoController@destroy');

// PreCosteo Detalles
Route::get('precosteo/detalles/{id}', 'PresupuestoDetallesController@show');

// Empresas
Route::get('empresas', 'EmpresaController@index');
Route::get('empresas/{id}', 'EmpresaController@show');
Route::post('empresas', 'EmpresaController@store');
Route::put('empresas/{id}', 'EmpresaController@update');
Route::delete('empresas/{id}', 'EmpresaController@destroy');

// Campañas
Route::get('campania', 'CampaniaController@index');
Route::get('campania/{id}', 'CampaniaController@show');
Route::post('campania', 'CampaniaController@store');
Route::put('campania/{id}', 'CampaniaController@update');
Route::delete('campania/{id}', 'CampaniaController@destroy');

// Plazas
Route::get('plazas', 'PlazaController@index');
Route::get('plazas/{id}', 'PlazaController@show');
Route::post('plazas', 'PlazaController@store');
Route::put('plazas/{id}', 'PlazaController@update');
Route::delete('plazas/{id}', 'PlazaController@destroy');

// Tipo Medio
Route::get('tipomedio', 'TipoMedioController@index');
Route::get('tipomedio/{id}', 'TipoMedioController@show');
Route::post('tipomedio', 'TipoMedioController@store');
Route::put('tipomedio/{id}', 'TipoMedioController@update');
Route::delete('tipomedio/{id}', 'TipoMedioController@destroy');

// Entidades Federativas
Route::resource('estados', 'EstadosController');

// Tipo Proveedor
Route::resource('tipoproveedor', 'TipoProveedorController');
//Route::get('tipoproveedor/{id}', 'TipoProveedorController@show');
//Route::post('tipoproveedor','TipoProveedorController@store');
//Route::put('tipoproveedor/{id}', 'TipoProveedorController@update');

// Instaladores
Route::get('datosInstalacion/{id}', 'InstaladoresController@show');

// Rutas
Route::resource('rutas', 'RutasController');
Route::get('ruta/simple/', 'RutasController@getSimple');
Route::get('ruta/{id}/rutas', 'RutasController@getRutaProveedor');
Route::post('ruta/{id}/rutas', 'RutasController@setRutaProveedor');


// Clientes
Route::resource('clientes', 'ClientesController');

// Unidades Transporte Urbano
Route::resource('camiones', 'UnidadesController');
Route::get('camiones/{id_proveedor}/{num_eco}', 'UnidadesController@getByNumEco');
Route::get('buscar/camion', 'UnidadesController@getByPlaca');

// Tipo Material
Route::resource('tipomaterial', 'TipoMaterialController');

// Tipo Usuario
Route::resource('tipousuario', 'TipoUsuarioController');

// Usuarios
Route::resource('usuarios', 'UsuariosController');
Route::get('buscar/usuario', 'UsuariosController@filterUsers');

// Herramientas
Route::get('herramientas/folio/{tipo_folio}', 'HerramientasController@getNextFolio');