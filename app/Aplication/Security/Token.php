<?php
namespace ThisApp\Aplication\Security;

use \ThisApp\Aplication\Security\Session;
use \ThisApp\Aplication\System\Config;
/**
*
*/
class Token
{

	public static function create()
	{
		if (isset($_SESSION["gTokens"])) {
			$cant = $_SESSION["gTokens"];
			$_SESSION["gTokens"] = $cant +1;
		}else{
			$_SESSION["gTokens"] = 1;
		}
		return Session::put(Config::get("session/token_name"), sha1(uniqid()));
	}

	public static function validate($token){
		$tokenName = Config::get("session/token_name");

		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		return false;
	}
}
 ?>
