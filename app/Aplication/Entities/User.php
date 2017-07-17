<?php
namespace ThisApp\Aplication\Entities;

use \ThisApp\Aplication\Functions\Helpers;

class User
{
	private $id,
          $nick,
          $correo,
          $img,
          $rol,
          $pass,
          $salt,
          $fecha_crea,
          $facebook_id,
          $activo,
          $_error,
          $confirmation_code;

	function __construct($nick, $correo, $rol, $activo)
	{
          $this->nick = $nick;
          $this->correo = $correo;
          $this->rol = $rol;
          $this->activo = $activo;
	}
//Setters
	public function setId($id){
		$this->id = $id;
	}
	public function setNick($nick){
		$this->nick = $nick;
	}
	public function setCorreo($correo){
		$this->correo = $correo;
	}
	public function setImg($img){
		$this->img = $img;
	}
	public function setRol($rol){
		$this->rol = $rol;
	}
	public function setPass($pass){
		$this->pass = $pass;
	}
	public function setSalt($salt){
		$this->salt = $salt;
	}
	public function setFechaCrea($fecha_crea){
		$this->fecha_crea = $fecha_crea;
	}
	public function setFacebookId($facebook_id){
		$this->facebook_id = $facebook_id;
	}
	public function setActivo($activo){
		$this->activo = $activo;
	}
	public function setConfirmationCode($confirmation_code){
		$this->confirmation_code = $confirmation_code;
	}
//Getters
	public function getId(){
		return $this->id;
	}
	public function getNick(){
		return $this->nick;
	}
	public function getCorreo(){
		return $this->correo;
	}
	public function getImg(){
		return $this->img;
	}
	public function getRol(){
		return $this->rol;
	}
	public function getPass(){
		return $this->pass;
	}
	public function getSalt(){
		return $this->salt;
	}
	public function getFechaCrea(){
		return $this->fecha_crea;
	}
	public function getFacebookId(){
		return $this->facebook_id;
	}
	public function getActivo(){
		return $this->activo;
	}
	public function getConfirmationCode(){
		return $this->confirmation_code;
	}

	public function inserts($encode = false){
		return array(
          "nick" => $encode ? utf8_encode($this->nick) : $this->nick,
          "correo" => $encode ? utf8_encode($this->correo) : $this->correo,
          "img" => $encode ? utf8_encode($this->img) : $this->img,
          "rol" => $encode ? utf8_encode($this->rol) : $this->rol,
          "pass" => $encode ? utf8_encode($this->pass) : $this->pass,
          "salt" => $encode ? utf8_encode($this->salt) : $this->salt,
          "fecha_crea" => $encode ? utf8_encode($this->fecha_crea) : $this->fecha_crea,
          "facebook_id" => $encode ? utf8_encode($this->facebook_id) : $this->facebook_id,
          "activo" => $encode ? utf8_encode($this->activo) : $this->activo,
          "confirmation_code" => $encode ? utf8_encode($this->confirmation_code) : $this->confirmation_code
			); 
	}
}