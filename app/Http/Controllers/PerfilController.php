<?php

/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel HernÃ¡ndez <emmanuelhd@gmail.com>
 *
 *  Prohibida su reproducciÃ³n parcial o total sin 
 *  consentimiento explÃ­cito de Integra Ideas Consultores.
 *
 *  Noviembre - 2018
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use Auth, View, Session, Lang, Route;


class PerfilController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/
    
    /** 
	 * ==================================================================== 
	 * FunciÃ³n para verificar que se tenga seleccionado el producto al inicio de la ediciÃ³n
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function editarInicio(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
		    return view('/usuario/perfil');
		} else {
            return view('auth.login');
		}
	}
    
    /** 
	 * ==============================================================
	 * FunciÃ³n para regresar los datos.
	 * ==============================================================
	*/
	public function get_perfil(Request $request)
	{
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        /* FormulaciÃ³n */
        $sql='SELECT `name`,`email`,`avatar`
            FROM users AS u
            WHERE u.`id`=:id_usuario ';
    
                
        $res = DB::select($sql, ['id_usuario'=>$idUser]);
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'         => 'success',
			'data'    => $res,
		]);
	}
    
    /** ==============================================================
	 * FunciÃ³n para duardar los datos.
	 * ==============================================================
     */
	public function set_perfil(Request $request)
	{
        $input = $request->except(['_token']);
		
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;
        
        
        /* Obtiene el id del usuario */
        $idUser    = Auth::user() -> id;
        
		/* Se agregan los valores enviados por el usuario y se guarda en la BD */
		try {
            $user               = User::find($idUser);		  
			$user -> name   = $request->name;
            $user -> email   = $request->email;
            $user -> avatar   = $request->avatar;
			$user -> save();
		} catch (Exception $e) { return response() -> json(['message' => $e -> getMessage()], 401);	}

		

		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Información guardada con éxito.',
		]);
	}
}