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


class ClientesedocuentaController extends Controller
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
		if ( Auth::check() )
		{
			
			     return view('/clientes/admin');
		} else {
			return view('auth.login');
		}
	}

    /** 
	 * ==================================================================== 
	 * Edición
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function form(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{

            //Existente
    		if($request->id>0 ){	
                Session::put('contratos_id',$request->id);
                
                $sql='SELECT id,concat(icode,"-",idesc) AS idesc
                        FROM `contratos`
                        WHERE id=:contratos_id';
                
                $res = DB::select($sql, ['contratos_id'=>$request->id]);
                if(count($res)>0)
                    Session::put('contratos_idesc',$res[0]->idesc);
            }
            else{//Nuevo
                Session::put('contratos_id',0);
                Session::put('contratos_idesc','Nuevo');
            }
                
            return view('/clientes/clienteedocuenta');
            
		} else {
			return view('auth.login');
		}
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
		$idUser    = Auth::user() -> id;

        /* Reporte */
        $params = Array(Session::get('contratos_id'));
        //dd($params);
        $res = CallRaw('rpt_edocuenta(CONCAT("&id_contratos=",?))',$params);

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'     => 'success',
			'datos'      => $res[0],
            'headers'      => $res[1],
		]);
	}
    
    /** 
	 * ==================================================================== 
	 * Obtener el estado de cuenta
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function set_edocuenta(Request $request)
	{
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;
        if(($res=$this->Validar_set_movimiento($request))["status"]){
            try{
    		     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$objeto   = new Clieprovedocuenta();
                
                $objeto["id_clieprov"]=Session::get("clientes_id");
                $objeto["id_contratos"]=Session::get("contratos_id");
                
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
	 * Quitar movimientos
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
    public function quitar_edocuenta(Request $request)
	{
        
	       try{
	           $objeto = Clieprovedocuenta::where('id', $request["id"])
				    ->first();
                if ( $objeto != null ){
                        
                    $objeto["state"]="E";
                    //var_dump($objeto);
            		$objeto -> save();
                    
                    /* Regreso la respuesta exitosa  */
            		return response() -> json([
            			'status'  => 'success',
            			'msg'     => 'Movimiento eliminado con éxito.',
            		]);
                }
                else{
                    /* Regreso la respuesta exitosa  */
            		return response() -> json([
            			'status'  => 'error',
            			'msg'     => 'Error al intentar eliminar el registro.',
            		]);
                }
    		}
    		catch (Exception $e) { return $e->getMessage();	}
    
    		
    
    		
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