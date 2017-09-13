<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*ARCHIVOS*/
Route::get('/archivos', 'ArchivoController@index');
Route::resource('area.documentos', 'AreaDocumentoController', ['only' => 'index']);

/*AREAS*/
Route::get('/areas', 'AreaController@index');

/*CASOS*/
Route::get('/casos', 'CasoController@index');
Route::resource('caso.archivos', 'CasoArchivoController', ['only' => ['index', 'store']]);

/*DESPACHO*/
#rutas que usara modulo de petroleo
Route::get('/despachoTjoselito', 'DespachoTjoselitoController@index');
Route::get('/despachoTjc', 'DespachoTjcController@index');

/*DOCUMENTOS*/
Route::get('/documentos', 'DocumentoController@index');

/*ENVIO*/
Route::get('/envios', 'EnvioController@index');

/*USUARIO*/
Route::resource('usuario.casos', 'UserCasoController', ['only' => ['index', 'store', 'destroy']]);
#lista de usuarios
Route::get('/usuarios', 'UserController@index');
#rutas para registrar usuario
Route::post('registrar', 'UserController@register');
#ruta para iniciar sesión
Route::post('login', 'UserController@login');
#ruta para conseguir usuario autenticado
Route::group(['middleware' => 'jwt.auth'], function (){
	Route::get('usuario', 'UserController@getAuthUser');
});