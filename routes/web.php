<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

	/* Rutas de Nomina*/
Route::get('/clientes/admin', 'ClientesController@admin')->name('adminClientes');
Route::get('/clientes/registro', 'ClientesController@registro')->name('registroClientes');
Route::post('/clientes/get_admin', 'ClientesController@get_admin')->name('get_adminClientes');
Route::post('/clientes/get_edocuenta', 'ClientesController@get_edocuenta')->name('get_edocuentaClientes');
Route::post('/clientes/set_movimiento', 'ClientesController@set_movimiento')->name('set_movimientoClientes');

Route::get('/inicio', 'MenuController@index')->name('inicio');

