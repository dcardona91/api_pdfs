<?php
namespace ThisApp\Core;
#llamar las instancias
use Exception;

class Response
{
	private $_response, $_status, $_msg, $_pagination =  false, $_next, $_prev, $_error;

	public function setResponse($_response){
		$this->_response = $_response;
	}

	public function setSatus($status){
		$this->_status = $status;
	}

	public function setMsg($msg){
		$this->_msg = $msg;
	}

	public function setPagination($pagination){
		$this->_pagination = $pagination;
	}

	public function setNext($next){
		$this->_pagination = true;
		$this->_next = $next;
	}

	public function setPrev($prev){
		$this->_pagination = true;
		$this->_prev = $prev;
	}

	public function setError(Exception $e){
		$this->_msg = $e->getMessage();
		$this->_status = $e->getCode();
		$this->_error = array("message"=>$e->getMessage(), "code"=>$e->getCode(), "file"=>$e->getFile(), "line"=>$e->getLine());
	}


	/*GETTERS*/
	public function getResponse(){
		return $this->_response;
	}

	public function getSatus(){
		return $this->_status;
	}

	public function getMsg(){
		return $this->_msg;
	}

	public function getPagination(){
		return $this->_pagination;
	}

	public function getNext(){
		return $this->_next;
	}

	public function getPrev(){
		return $this->_prev;
	}

	public function getError(){
		return $this->_error;
	}

	public function json($method){
		$response = array("response" => $this->_response,
				"status" => $this->_status,
				"msg" => $this->_msg,
				"pagination" => array("status" => $this->_pagination, "next" => $this->_next,
				"prev" => $this->_prev),				
				"error" => $this->_error);
		header('Access-Control-Allow-Methods: '.strtoupper($method));
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}
}