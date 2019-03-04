<?php

/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) jaime vaázquez
 *
 *  Prohibida su reproducciÃ³n parcial o total sin 
 *  consentimiento explÃ­cito de Integra Ideas Consultores.
 *
 *  Noviembre - 2018
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, View, Session, Lang, Route;


class MainController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    /** 
	 * ==================================================================== 
	 * Admin
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function index(Request $request)
	{
        //Checar el get=ruta
        //dd(->middleware('auth'))
        $ruta='';
        if(strlen($request->ruta)>0)
            $ruta=route($request->ruta);
        else{
            if (Auth::user()->rol == 'admin') {
                $ruta=route('adminClientes');
            }
            else{
                $ruta='';
            }            
        }
        
        return view('/main_content', compact('ruta'));
	}
}