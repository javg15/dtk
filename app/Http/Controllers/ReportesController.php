<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers;

use Auth, View, Session, Lang, Route;


class ReportesController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/
    
    /** 
	 * ==================================================================== 
	 * Función para verificar que autenticado al inicio de la edición
	 * 
	 * @author Jaime Vázquez
	 * ====================================================================
	*/
    public function indice(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			     return view('/reportes/indice');
		} else {
			return view('auth.login');
		}
	}
	public function saldos(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			     return view('/reportes/saldos');
		} else {
			return view('auth.login');
		}
	}
    
    public function pagos(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			     return view('/reportes/pagos');
		} else {
			return view('auth.login');
		}
	}
    
    public function edocuenta(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
            if (Auth::user()->rol == 'admin') {
                $sql='SELECT id,icode,idesc
                        FROM `clieprovs`
                        WHERE state IN("A","B")';
                $res = DB::select($sql);                        
            }
            else{
                $idUser = Auth::user() -> id; 
                               
                $sql='SELECT id,icode,idesc
                        FROM `clieprovs`
                        WHERE id=:id_cliente    
                            AND state IN("A","B")';
                $res = DB::select($sql,["id_cliente"=>$idUser]);                                                                            
            }
            
                
            return view('/reportes/edocuenta',[
			 'clientes' => $res,
		]);
        
		} else {
			return view('auth.login');
		}
	}
    
    public function get_contratos(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
		     $sql='SELECT id,concat(icode,"-",idesc) as idesc
                        FROM `contratos`
                        WHERE
                            id_clieprovs=:id_clieprovs                            
                            AND state IN("A","B")';	  	
                            	  
            if (Auth::user()->rol == 'admin') {
                $idUser = Auth::user() -> id;
                $res = DB::select($sql,["id_clieprovs"=>$idUser]);                
            }
            else{
                $res = DB::select($sql,["id_clieprovs"=>$request->id_cliente]);
            }                                            
                
            return response() -> json([
    			'status'     => 'success',
    			'datos'      => $res,
            ]);
        
		} else {
			return view('auth.login');
		}
	}

    
    /** 
	 * ==============================================================
	 * Funciones para mostrar los reportes.
	 * ==============================================================
	*/
	public function get_saldos(Request $request)
	{
        if ( Auth::check() ){
            /* Obtengo el id del usuario */
    		$idUser    = Auth::user() -> id;
            
            /* Reporte */
            $fecha = (new \DateTime($request["fechacorte"]))->setTime(0, 0);
            $fecha=$fecha->format("Y-m-d");
                    
            $params = [$fecha];
            $res = CallRaw('rpt_saldos(CONCAT("&fechacorte=",?))',$params);
    
    		/* Regreso la respuesta con los datos para el jExcel */
    		return response() -> json([
    			'status'     => 'success',
    			'datos'      => $res[0],
                'headers'    => $res[1],
                'align_right'=> $res[2],
                'titulo'=> 'Reporte de saldos',
    		]);
     	} else {
			return view('auth.login');
		}
	}
    
    public function get_pagos(Request $request)
	{
        
        /* Obtengo el id del usuario */
        if ( Auth::check() ){
    		$idUser    = Auth::user() -> id;
            
            /* Reporte */
            $fechai = (new \DateTime($request["fechainicio"]))->setTime(0, 0);
            $fechai=$fechai->format("Y-m-d");
            $fecha = (new \DateTime($request["fechacorte"]))->setTime(0, 0);
            $fecha=$fecha->format("Y-m-d");
                    
            $params = [$fechai,$fecha];
            $res = CallRaw('rpt_pagos(CONCAT("&fechainicio=",?,"&fechacorte=",?))',$params);
    
    		/* Regreso la respuesta con los datos para el jExcel */
    		return response() -> json([
    			'status'     => 'success',
    			'datos'      => $res[0],
                'headers'    => $res[1],
                'align_right'=> $res[2],
                'titulo'=> 'Reporte de pagos',
    		]);
        } else {
			return view('auth.login');
		}
	}
    
    public function get_edocuenta(Request $request)
	{
        if ( Auth::check() ){
            /* Obtengo el id del usuario */
    		$idUser    = Auth::user() -> id;
            
            /* Reporte */
            $params = Array($request->id_contrato);
            //dd($params);
            $res = CallRaw('rpt_edocuenta(CONCAT("&id_contratos=",?))',$params);
    
    		/* Regreso la respuesta con los datos para el jExcel */
    		return response() -> json([
    			'status'     => 'success',
    			'datos'      => $res[0],
                'headers'    => $res[2],
                'align_right'=> $res[3],
                'encabezado'      => $res[4],
    		]);
        } else {
			return view('auth.login');
		}
	}
    
    
}