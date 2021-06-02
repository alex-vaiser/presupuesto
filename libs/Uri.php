<?php

class Uri{

	/**
	 * Descripción : Obtiene la url base
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 01-05-2020	 
	 * @return     : (String)
	 */
	public static function getBaseUri(){

		$_protocol = "http";
		$_port     = '';
		$_arrPath  = explode('/',trim($_SERVER["SCRIPT_NAME"],'/'));
		$_app      = array_shift($_arrPath);
		
		if(!empty($_SERVER["HTTPS"]))     $_protocol = strtolower($_SERVER["HTTPS"]);
		if($_SERVER["SERVER_PORT"] != 80) $_port     = ':' . $_SERVER["SERVER_PORT"];
		
		return $_protocol . '://' . $_SERVER["SERVER_NAME"] . $_port . '/' . $_app . '/';		
		
	}

	/**
	 * Descripción : Obtiene el host
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 01-05-2020	 
	 * @return     : (String)
	 */
	public static function getHost(){

		$_protocol = "http";
		$_port     = '';

		if(!empty($_SERVER["HTTPS"]))     $_protocol = strtolower($_SERVER["HTTPS"]);
		if($_SERVER["SERVER_PORT"] != 80) $_port     = ':' . $_SERVER["SERVER_PORT"];

		return $_protocol . '://' . $_SERVER["SERVER_NAME"] . $_port . '/';

	}
}
?>