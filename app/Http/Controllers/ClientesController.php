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
use App\Http\Helpers;

//use App\Producto, App\Catum, App\User, App\Etapa, App\Nomina;
use App\Clieprovedocuenta;
use Auth, View, Session, Lang, Route;


class ClientesController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/
    
    /** 
	 * ==================================================================== 
	 * Admin
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function admin(Request $request)
	{
		/* El usuario debe estar loggeado */
		/*if ( Auth::check() )
		{*/
			
			     return view('/clientes/admin');
		/*} else {
			return view('auth.login');
		}*/
	}

/** 
	 * ==================================================================== 
	 * Edición
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function registro(Request $request)
	{
		/* El usuario debe estar loggeado */
		/*if ( Auth::check() )
		{*/
		if(Session::get('id_clieprov')!=null || $request->id_clieprov>0 ){	
            Session::put('id_clieprov',$request->id_clieprov);
            
            $sql='SELECT id,icode,idesc 
                    FROM `clieprovs`
                    WHERE id=:id_clieprov';
            
            $res = DB::select($sql, ['id_clieprov'=>$request->id_clieprov]);
            if(count($res)>0)
                Session::put('idesc_clieprov',$res[0]->idesc);
                
            return view('/clientes/registro');
    		/*} else {
    			return view('auth.login');
    		}*/
        }
        else
            return view('/clientes/admin');
	}    
    /** 
	 * ==================================================================== 
	 * Obtener el estado de cuenta
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function get_admin(Request $request)
	{
		/* Obtengo el id del usuario */
		//$idUser    = Auth::user() -> id;
        
        /* InversiÃ³n inicial */
        $sql='SELECT id,icode,idesc as cliente,COALESCE(get_saldo(id),0) AS saldo
                FROM `clieprovs`';

        //$res = DB::select($sql, ['id_cliente'=>$request->$id]);
        $res = DB::select($sql);        
        

        //var_dump($datainversion);
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'        => 'success',
			'data'   => $res,
		]);
	}
    
    /** 
	 * ==================================================================== 
	 * Obtener el estado de cuenta
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function get_edocuenta(Request $request)
	{
		/* Obtengo el id del usuario */
		//$idUser    = Auth::user() -> id;
        
        /* Reporte */
        $params = Array(Session::get("id_clieprov"),$request->fechainicio,$request->fechafin);
        //dd($params);
        $res = CallRaw('rpt_edocuenta(CONCAT("&id_clieprov=",?,"&fechainicio=",?,"&fechafin=",?))',$params);

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'     => 'success',
			'datos'      => $res[0],
            'headers'      => $res[1],
		]);
	}

    /** 
	 * ==================================================================== 
	 * Registrar el movimiento
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function set_movimiento(Request $request)
	{
	/* Obtiene el id del usuario */
		//$idUser = Auth::user() -> id;
        if(($res=$this->Validar_set_movimiento($request))["status"]){
            try{
    		     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$objeto   = new Clieprovedocuenta();
                
                $objeto["id_clieprov"]=Session::get("id_clieprov");
                
                $fecha = (new \DateTime($request["fecha"]))->setTime(0, 0);
                $objeto["fecha"]=$fecha->format("Y-m-d");
                
                if($request["movimiento"]==1)
                    $objeto["cargo"]=$request["cantidad"];
                else
                    $objeto["abono"]=$request["cantidad"];
                    
                $objeto["idesc"]=$request["concepto"];
                //var_dump($objeto);
        		$objeto -> save();
    		}
    		catch (Exception $e) { return $e->getMessage();	}
    
    		
    
    		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
    		return response() -> json([
    			'status'  => 'success',
    			'msg'     => 'Información guardada con éxito.',
    		]);
        }
        else{
            return response() -> json([
    			'status'  => 'error',
    			'msg'     => $res["msg"],
    		]);
        }
	}
    
     /** 
	 * ==================================================================== 
	 * Validar entrada de datos
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function Validar_set_movimiento(Request $request)
	{
	   $msg='';

       if(!(validateDate($request["fecha"])))$msg.="<li>Fecha inválida</li>";
       if(!($request["movimiento"]>0))$msg.="<li>El tipo de movimiento es inválido<br>";
       if(!(strlen($request["concepto"]))>0)$msg.="<li>Concepto inválido</li>";
       
       if($msg!='')
            return Array("msg"=>'<ul>'.$msg.'</ul>',"status"=>false);  
       
       return Array("status"=>true);
    }
     
       
    
}