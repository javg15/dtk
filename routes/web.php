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
Route::get("/main_content", function()
{
   return View::make("main_content");
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/* Rutas de clientes*/
Route::get('/clientes/admin', 'ClientesController@admin')->name('adminClientes');
Route::get('/clientes/form', 'ClientesController@form')->name('formClientes');
Route::post('/clientes/get_admin', 'ClientesController@get_admin')->name('get_adminClientes');
Route::post('/clientes/get_registro', 'ClientesController@get_registro')->name('get_registroClientes');
Route::post('/clientes/set_registro', 'ClientesController@set_registro')->name('set_registroClientes');


/* Rutas de contratos*/
Route::get('/contratos/admin', 'ContratosController@admin')->name('adminContratos');
Route::get('/contratos/form', 'ContratosController@form')->name('formContratos');
Route::post('/contratos/get_admin', 'ContratosController@get_admin')->name('get_adminContratos');
Route::post('/contratos/set_registro', 'ContratosController@set_registro')->name('set_registroContratos');
Route::post('/contratos/get_registro', 'ContratosController@get_registro')->name('get_registroContratos');

/* Rutas de moviemintos en estado de cuenta*/
Route::get('/clientesedocuenta/form', 'ClientesedocuentaController@form')->name('formClientesedocuenta');
Route::post('/clientesedocuenta/get_edocuenta', 'ClientesedocuentaController@get_edocuenta')->name('get_edocuentaClientesedocuenta');
Route::post('/clientesedocuenta/set_edocuenta', 'ClientesedocuentaController@set_edocuenta')->name('set_edocuentaClientesedocuenta');
Route::post('/clientesedocuenta/quitar_edocuenta', 'ClientesedocuentaController@quitar_edocuenta')->name('quitar_edocuentaClientesedocuenta');

Route::get('/inicio', 'MenuController@index')->name('inicio');

