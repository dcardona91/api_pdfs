<?php
namespace ThisApp\Aplication\Security;

use \ThisApp\Aplication\System\Config;
/**
*
*/
class Session
{
	public static function exists($name)
	{
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function put($name, $value)
	{
		return $_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		return $_SESSION[$name];
	}

	public static function setFlash($titulo, $mensaje, $type = "info")
	{
		/*success, info, warning, danger*/
		$valor = [ "titulo"=> $titulo, "mensaje" => $mensaje,"type"=> $type];
		Self::put(Config::get("session/flash_msg"), $valor);
		return true;
	}

	public static function getFlash()
	{
		$flash = false;
		if(isset($_SESSION[Config::get("session/flash_msg")]))
		{
			$flash = $_SESSION[Config::get("session/flash_msg")];
			Self::delete(Config::get("session/flash_msg"));
		}
		return $flash;
	}


	public static function delete($name=null)
	{
		if (self::exists($name)) {
			unset($_SESSION[$name]);
		}
		//session_destroy();
	}

	public static function destroy()
	{	
		session_destroy();
	}

	public static function flash($name, $array)
	{
		if (self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		}else{
			self::put($name, $array);
		}
	}
}
