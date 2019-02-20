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
	 * FunciÃ³n para verificar que se tenga seleccionado el producto al inicio de la ediciÃ³n
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function registro(Request $request)
	{
		/* El usuario debe estar loggeado */
		/*if ( Auth::check() )
		{
			
			/* El usuario debe tener un producto seleccionado */
			/*if ( Session::get('prodSeleccionado') == null )
			{
				return redirect('/productomenu');
			} else {*/
			     return view('/clientes/registro');
			/*}*/
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
	public function get_edocuenta(Request $request)
	{
		/* Obtengo el id del usuario */
		//$idUser    = Auth::user() -> id;
        
        /* Reporte */
        $params = Array($request->clieprov,$request->fechainicio,$request->fechafin);
        //dd($params);
        $res = $this->CallRaw('rpt_edocuenta(CONCAT("&id_clieprov=",?,"&fechainicio=",?,"&fechafin=",?))',$params);

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

        try{
			//$objeto = Nomina::where('id_user', $idUser)
            $objeto = Clieprovedocuenta::where('id_clieprov', 1)
				->first();
            
			if ( $objeto == null ){
			     
			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$objeto   = new Clieprovedocuenta();
                
                //$objeto["id_user"]=$idUser;
            }
            
            $objeto["id_clieprov"]=$request["clieprov"];
            $objeto["fecha"]=$request["fecha"];
            $objeto["cargo"]=preg_replace('/[^0-9.]+/', '', $request["cargo"]);
            $objeto["abono"]=preg_replace('/[^0-9.]+/', '', ($request["abono"]==""?0:$request["abono"]));
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
        
    /** 
	 * ==============================================================
	 * Llamada generica a SP's 
	 * ==============================================================
	*/
    public static function CallRaw($procName, $parameters = null, $isExecute = false)
    {
        /*$syntax = '';
        for ($i = 0; $i < count($parameters); $i++) {
            $syntax .= (!empty($syntax) ? ',' : '') . '?';
        }*/
        $syntax = 'CALL ' . $procName . ';';
    
        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $pdo->prepare($syntax,[\PDO::ATTR_CURSOR=>\PDO::CURSOR_SCROLL]);
        for ($i = 0; $i < count($parameters); $i++) {
            $stmt->bindValue((1 + $i), $parameters[$i]);
        }
        $exec = $stmt->execute();
        if (!$exec) return $pdo->errorInfo();
        if ($isExecute) return $exec;
    
        $results = [];
        do {
            try {
                $results[] = $stmt->fetchAll(\PDO::FETCH_OBJ);
            } catch (\Exception $ex) {
    
            }
        } while ($stmt->nextRowset());
    
    
        if (1 === count($results)) return $results[0];
        return $results;
    }
}