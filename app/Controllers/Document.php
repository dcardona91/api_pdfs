<?php
namespace ThisApp\Controllers;

use Exception;
use \ThisApp\Core\Response;
use \ThisApp\Models\Pdf;
/**
* 
*/

class Document{

	public function get($params = null)
	{


		$r = new Response();
		try {
			$parameters = json_decode($params);
			if (isset($parameters->indicators[0])) {
				$pdf =  new Pdf();
				$rpta = $pdf->generate($parameters->indicators[0], $parameters->queryString);
				if( $rpta == -1){
					$r->setStatus(404);
					$r->setMsg("El documento no existe");
					$r->output("GET");
				}else{
					$r->setStatus(200);
					$r->setMsg("Documento generado correctamente");
					$r->setResponse(array("document" => "http://192.168.33.10/documents/".$rpta));
					$r->output("GET");
				}
			}else{				
				$r->setStatus(404);
				$r->setMsg("No se definió indicador");
				$r->output("GET");
				//throw new Exception("No se definió indicador");
			}			
		} catch (Exception $e) {
			// die($e->getMessage());
			$r->setError($e);			
			$r->output("GET");
		}		
	}

	public function post($params = null)
	{		
		//Deliver::output(array("status"=>200), "POST");
	}

	public function put($params = null)
	{
		$response = new Response();
		try {
			$response->setResponse(array("some_val"=>"foo", "other_val" => "bar"));
			$response->setSatus(200);
			$response->setMsg("Listado de valores de prueba");			
			throw new Exception("Some error text", 500);			
		} catch (Exception $e) {
			$response->setError($e);
		}
		$response->json("PUT");
	}

	public function delete($params = null)
	{

		//Deliver::json(array("status"=>200), "DELETE");
	}

	/*
	public function getOld($params = null)
	{	
		try {
		$response = new Response();		
		$oUser =  new User();
		$ind = json_decode($params)->indicators;	
		$result = $oUser->getUser(array("field"=>$ind[1], "criteria"=>$ind[2], "value"=> "%".$ind[3]."%"));
		if (is_array($result)) {
				throw new Exception("SQL_code: ".$result[0]." - Driver_code: ".$result[1]." - Message: ".$result[2], 500);			
		}
		$response->setResponse($result->inserts(true));
		$response->setSatus(200);
		$response->setMsg("Usuarios con ".$ind[1]." ".$ind[2]." a ".$ind[3]);
		} catch (Exception $e) {
			$response->setError($e);
		}
		$response->json("GET");
	}
	*/
}
