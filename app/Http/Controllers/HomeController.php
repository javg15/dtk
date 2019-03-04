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


class HomeController extends Controller
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
        
	   if(Auth::check()){
	       
            if (Auth::user()->rol == 'customer') {
                //dd(Auth::user()->rol);
                return redirect('/main_content/?ruta=edocuentaReportes');
            }
            elseif (Auth::user()->rol == 'agent') {
                return redirect('/main_content/?ruta=edocuentaReportes');
            }
            elseif (Auth::user()->rol == 'admin') {
                return redirect('/main_content');
            }
            else{
                return redirect('welcome');
                            
            }            
        }
		/* El usuario debe estar loggeado */
		/*if ( Auth::check() )
		{
            //if($user->isAdmin())
            if(Auth::user()->rol=="admin")
                return redirect('/home');
            else
                return redirect('reportes.edocuenta');
		} else {
			return redirect('auth.login');
		}
        return redirect('/');*/
	}
}