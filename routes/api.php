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

//********tablas dinamicas para la seleccion segun el valor WEB SERVIS*******//
Route::get('/DepDocId/{id}/Municipio', 'MunicipioController@byProjet');
//********tablas dinamicas para la seleccion segun el valor*******//