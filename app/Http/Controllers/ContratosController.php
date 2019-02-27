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
use App\Contrato;
use Auth, View, Session, Lang, Route;


class ContratosController extends Controller
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
            
                if($request->id>0 ){//Cliente activo
                    
                    Session::put('clientes_id',$request->id);
                    
                    $sql='SELECT id,icode,idesc
                            FROM `clieprovs`
                            WHERE id=:clientes_id';
                    
                    $res = DB::select($sql, ['clientes_id'=>$request->id]);
                    
                    if(count($res)>0)
                        Session::put('clientes_idesc',$res[0]->idesc);
                }
			
			     return view('/clientes/contratoadmin');
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
                Session::put('contratos_id',$request->id);
                
                $sql='SELECT id,icode,idesc
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
                
            return view('/clientes/contrato');
            
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
	        
        $params = Array("id_clieprovs", Session::get('clientes_id'),2);
		$res = CallRaw('s_contrato_mgr(CONCAT("&fkey=",?,"&fkeyvalue=",?,"&modo=",?))',$params);
        

        //var_dump($datainversion);
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
            $id=Session::get('contratos_id');
            
            //registro
            $sql='SELECT id,icode,idesc,`numparcialidades`,`fechainicio`,`anticipo`,total
                    FROM `contratos`
                    WHERE id=:contratos_id';
            $res = DB::select($sql, ['contratos_id'=>$id]);
            
            //tabla de parcialidades
            $sqltabla='SELECT DATE(`fecha`) AS fecha,`cargo`
            		FROM `clieprovedocuentas`
                    WHERE id_contratos=:contratos_id';
            $restabla = DB::select($sqltabla, ['contratos_id'=>$id]);
            
            /* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
    		return response() -> json([
                'data'      => $res,
                'datatabla' => $restabla,
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
                $contrato_id=Session::get("contratos_id");
                $obj = Contrato::where('id', $contrato_id)
    				->first();
    			if ( $obj == null ){
    			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
            		$obj   = new Contrato();
                    $generartabla=true;
                    $obj["id_clieprovs"]=Session::get("clientes_id");
                }
                else
                    $generartabla=false;
                    
                //Leer el json del excel
                $d=$request["datos"];
                
                for($i=0;$i<count($d);$i++){
                    //Llenar el arreglo segun el nombre de campo con el valor de las columna 2 del JExcel
                    if($d[$i]["value"]!=null){
                        if(in_array($d[$i]["name"], Array("generar")))
                            $generartabla=$d[$i]["value"];
                        else
                            $obj[$d[$i]["name"]]= $d[$i]["value"];
                    }
                }
                
        		$obj -> save();
                
                if($generartabla){
                    
                    $params = Array($obj->id);
                    $res = CallRaw('sp_contrato_tablaparcialidades_set(CONCAT("&id=",?))',$params);
                    Session::put("contratos_id",$obj->id);
                }
    		     
    		}
    		catch (Exception $e) { return $e->getMessage();	}
    
    		
            $sql='SELECT DATE(`fecha`) AS fecha,`cargo`
            		FROM `clieprovedocuentas`
                    WHERE id=:contratos_id';
            $res = DB::select($sql, ['contratos_id'=>$contrato_id]);
            
    		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
    		return response() -> json([
                'data'    => $res,
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
	 * Obtener el estado de cuenta
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function get_tablaparcialidades(Request $request)
	{
		/* Obtengo el id del usuario */
		//$idUser    = Auth::user() -> id;
        
        /* Reporte */
        $params = Array(Session::get("contratos_id"));
        //dd($params);
        $res = CallRaw('sp_contrato_parcialidades(CONCAT("&id=",?))',$params);

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'     => 'success',
			'datos'      => $res[0],
            'headers'      => $res[1],
		]);
	}
    
   

}