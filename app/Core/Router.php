<?php
namespace ThisApp\Core;
#llamar las instancias

use \Illuminate\Http\Request;
use \ThisApp\Aplication\Security\Session;
use \ThisApp\Aplication\System\Config;

class Router extends Request
{
	protected $params = array();

	public function __construct(Request $request)
	{
		$url = explode('/', filter_var(trim($request->getPathInfo(),'/'),FILTER_SANITIZE_URL));
		$this->params["queryString"] = $request->all();//Request::createFromGlobals()->request->all();
		if(file_exists('../app/Controllers/'.ucfirst(strtolower($url[0])).'.php'))
		{			
			$this->controller = ucfirst(strtolower($url[0]));
			unset($url[0]);
		}else{
			header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
			header('Content-Type: application/json');
			echo json_encode(array("status"=> 404, "message"=> "no entity defined"));
			exit;
		}
		//require_once '../app/controllers/'.$this->controller.'.php';
		$theController = "ThisApp\Controllers\\".$this->controller;
		$this->controller = new $theController;
		//if (isset($url[1]))
		//{
			if (method_exists($this->controller, strtolower($request->method()))) {
				$this->method = strtolower($request->method());//$url[1];
				//unset($url[1]);
			}else{
				header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
				header('Content-Type: application/json');
				echo json_encode(array("status"=> 404, "message"=> "no method allowed for that entity"));
				exit;
			}
		//}

		$this->params["indicators"] = $url ? array_values($url) : [];
		call_user_func_array([$this->controller, $this->method],array(json_encode($this->params)));
	}

}