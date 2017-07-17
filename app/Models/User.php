<?php
namespace ThisApp\Models;

use \ThisApp\Aplication\System\DB;
use \ThisApp\Aplication\System\Mail;
use \ThisApp\Aplication\Entities\User as eUser;
use \Exception;

class User
{
	public $_data,
			$_db;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function getUsers()
	{
		$table =  'usuarios';		
		$sql = "SELECT * FROM {$table} WHERE activo = :activo and rol = :rol;";
		if ($this->_db->query($sql, array("activo" => 1,"rol" => 1))->error() === false ) {
			$userCollection = array();
			foreach ($this->_db->results() as $i => $user) {
				$oUser = new eUser($user->nick, $user->correo, $user->rol, $user->activo);
				$oUser->setId($user->id);
				$oUser->setImg($user->img);
				$oUser->setPass($user->pass);
				$oUser->setSalt($user->salt);
				$oUser->setFechaCrea($user->fecha_crea);
				$oUser->setFaceId($user->facebook_id);
				$userCollection[] = $oUser;
			}
			return $userCollection;
		}
	}

	public function setUser(eUser $user, $facebook_id = false)
	{
		if (!$this->_db->insert("usuarios",$user->inserts())->error()) {
			try {
				$rpta = $this->_db->lastId();
				if (is_numeric($rpta)) {
					$confirmationLink = 'http://superev2.cieroccidente.edu.co/login/confirm/'.$user->getConfirmationCode();
					$nameTo = $user->getNick();
					$mailTo = $user->getCorreo();
					$subject = "Solicitud de confirmación de cuenta";

					$replaceVars = array(
									"nombreRecibe"=> $user->getNick(),
									"link"=>$confirmationLink,
									"email"=>$mailTo,
									"cohorte"=>'2017-1',
									"facebook"=>'https://www.facebook.com/Super%C3%A8-Envigado-627673587395865/',
									"twitter"=>'https://twitter.com/superenvigado');
					$html = $archivo = __DIR__."/../../public/mail/mail.html";
					$text = "Copia y pega el siguiente enlace en tu navegador para confirmar tu registro. ".$confirmationLink;
				if($facebook_id)	
					return $rpta;					
				else
					return Mail::send($nameTo, $mailTo, $subject, $text, $html, $replaceVars);
				}
			} catch (Exception $e) {
				return false;
			}			 
			//return $this->_pdo->lastInsertId();
		}
	}

	public function recoverPass($id, $email,$pass,$passu,$salt){

		$clave = $this->updateUser($id,["pass"=>$passu,"salt"=>$salt]);
		$confirmationLink = 'http://formacion.cieroccidente.edu.co/inicio/confirm/';
		$mailTo = $email;
		$subject = "Solicitud de recuperación de contraseña";
		$replaceVars = array(
						"pass"=>$pass,
						"email"=>$mailTo,
						"cohorte"=>'2017-1'
						);
		$html = $archivo = __DIR__."/../../public/mail/recover.html";
		$text = "Clave generada aleatoriamente, al ingresar cambiarla: ".$pass;
		return Mail::send("",$mailTo, $subject, $text, $html, $replaceVars);
	}

	public function getUser(array $criteria)
	{			
		$strCriteria = "";
		if (is_array(($criteria[0]))) {
			foreach ($criteria as $key => $crit) {
			$strCriteria += " ".$crit["field"] ." ". $crit["criteria"]." '".$crit["value"]."' ";
			if ( $key != count($crit)-1) {
				$strCriteria += "and ";
				}
			}
		}else{
			$strCriteria = " ".$criteria["field"] ." ". $criteria["criteria"]." '".$criteria["value"]."' ";
		}
		// var_dump($strCriteria);
		// exit();
		$sql = "SELECT * FROM usuarios WHERE ".$strCriteria." and seleccionado = '1'";

		if ($this->_db->query($sql)->count()>0) {
			//return $this->_db;
			$dbUser =  $this->_db->first();
			$eUser = new eUser($dbUser->nick, $dbUser->correo, $dbUser->rol, $dbUser->activo);
			$eUser->setId($dbUser->id);
	        $eUser->setNick($dbUser->nick);
	        $eUser->setCorreo($dbUser->correo);
	        $eUser->setImg($dbUser->img);
	        $eUser->setRol($dbUser->rol);
	        $eUser->setPass($dbUser->pass);
	        $eUser->setSalt($dbUser->salt);
	        $eUser->setFechaCrea($dbUser->fecha_crea);
	        $eUser->setFacebookId($dbUser->facebook_id);
	        $eUser->setActivo($dbUser->activo);
	        $eUser->setConfirmationCode($dbUser->confirmation_code);
	        return $eUser;
		}else{
			return array("error" => $this->_db->error());
		}
	}

	public function validateFacebookUser($facebook_id){
		return is_object($this->getUser(["facebook_id", "=" , $facebook_id]));
	}

	public function validateUser($field, $value){
		return $this->getUser(["field" => $field, 
								"criteria" =>"=" ,
								"value" => $value]);
	}

	public function updateUser($id, array $fields){	
		if($this->_db->update("usuarios", ["field"=>"id", "value"=>$id], $fields)->error())	
			return false;
		else
			return true;
	}

}