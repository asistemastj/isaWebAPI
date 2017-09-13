<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

#rutas para registrar usuario
Route::post('registrar', 'UserController@register');
#ruta para iniciar sesión
Route::post('login', 'UserController@login');
#ruta para conseguir usuario autenticado
Route::group(['middleware' => 'jwt.auth'], function (){
	Route::get('usuario', 'UserController@getAuthUser');
});

#rutas que usara modulo de petroleo
Route::get('/despachoTjoselito', 'DespachoTjoselitoController@index');
Route::get('/despachoTjc', 'DespachoTjcController@index');