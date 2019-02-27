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
use App\Clieprov;
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
			
			     return view('/clientes/clienteadmin');
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
	public function form(Request $request)
	{
		/* El usuario debe estar loggeado */
		/*if ( Auth::check() )
		{*/

            //Existente
    		if($request->id>0 ){	
                Session::put('clientes_id',$request->id);
                
                $sql='SELECT id,icode,idesc
                        FROM `clieprovs`
                        WHERE id=:clientes_id';
                
                $res = DB::select($sql, ['clientes_id'=>$request->id]);

                if(count($res)>0)
                    Session::put('clientes_idesc',$res[0]->idesc);
            }
            else{//Nuevo
                Session::put('clientes_id',0);
                Session::put('clientes_idesc','Nuevo');
            }
                
            return view('/clientes/cliente');
            
		/*} else {
			return view('auth.login');
		}*/
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
        
        //$res = DB::select($sql, ['id_cliente'=>$request->$id]);
        //$res = DB::select($sql);
        $res = CallRaw('s_clieprov_mgr("")');

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'     => 'success',
			'datos'      => $res[0],
            'headers'    => $res[1],
            'align_right'=> $res[2],
		]);        
        

	}
    
    /** 
	 * ==================================================================== 
	 * Edición
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function get_registro(Request $request)
	{
		/* El usuario debe estar loggeado */
		/*if ( Auth::check() )
		{*/
            $id=Session::get('clientes_id');
            
            $sql='SELECT id,icode,idesc,calle
                    FROM `clieprovs`
                    WHERE id=:clientes_id';
            $res = DB::select($sql, ['clientes_id'=>$id]);
            
            /* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
    		return response() -> json([
                'data'      => $res,
    			'status'    => 'success',
    			
    		]);
            
		/*} else {
			return view('auth.login');
		}*/
	}

        
     /** 
	 * ==================================================================== 
	 * Registrar el movimiento
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function set_registro(Request $request)
	{
	   
	/* Obtiene el id del usuario */
		//$idUser = Auth::user() -> id;
        //if(($res=$this->Validar_set_movimiento($request))["status"]){
            try{
                $cliente_id=Session::get("clientes_id");
                $obj = Clieprov::where('id', $cliente_id)
    				->first();
    			if ( $obj == null ){
    			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
            		$obj   = new Clieprov();
                    
                    //$obj["id_user"]=$idUser;
                }
                //Leer el json del excel
                $d=$request["datos"];
                for($i=0;$i<count($d);$i++){
                    //Llenar el arreglo segun el nombre de campo con el valor de las columna 2 del JExcel
                    if($d[$i]["value"]!=null)
                        $obj[$d[$i]["name"]]= $d[$i]["value"];
                }
                
        		$obj -> save();
            
    		     
    		}
    		catch (Exception $e) { return $e->getMessage();	}
    
    		
    
    		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
    		return response() -> json([
    			'status'  => 'success',
    			'msg'     => 'Información guardada con éxito.',
    		]);
        /*}
        else{
            return response() -> json([
    			'status'  => 'error',
    			'msg'     => $res["msg"],
    		]);
        }*/
	}
    
    /** 
	 * ==================================================================== 
	 * Quitar movimientos
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
    public function quitar_movimiento(Request $request)
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