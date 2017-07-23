<?php
namespace ThisApp\Aplication\System;

class Config{
/**
 * @type array
 */
	private static $globals = array(
			'mysql' => array(
				'host' =>  'localhost',
				'username'=> 'ciero_psocial01',
				'password' => 'psocial2017.',
				'db' => 'ciero_psocial'
				),
			'mailgun' => array(
				'api_key' => 'key-fa909a205b5b37610cdcc408ad8ad64b',
				'domain' => 'supere.cieroccidente.edu.co'
				),
			'site' => array(
				'name' => 'http://192.168.33.10',
				'ip' => ''
				)
			);

	public static function get($path = null){
		if ($path) {
			$config = self::$globals;
			$path = explode('/', $path);
			foreach ($path as $bit) {
				if (isset($config[$bit])) {
					$config = $config[$bit];
				}
			}
			return $config;
		}

		return false;
	}
}
