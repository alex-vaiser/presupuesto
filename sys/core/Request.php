<?php

class Request{

	private static $_module;
	private static $_controller;
	private static $_method;
	private static $_parameters;
	
	public function __construct(){

		$uri = (isset($_REQUEST['uk'])) ? base64_decode($_REQUEST['uk'],true) : false;
		
		if($uri) $_SERVER["REQUEST_URI"] = $uri;		

        $arr_uri   = array_slice(explode('/',trim($_SERVER["REQUEST_URI"],'/')),1);

        if(in_array('index.php',$arr_uri)) $arr_uri = array_slice($arr_uri,1);

        $quantity = count($arr_uri);

        if($quantity > 1){	        
	        
	        self::$_controller = array_shift($arr_uri);
	        self::$_method     = array_shift($arr_uri);
	        self::$_parameters = implode('/',$arr_uri);
	    	self::$_parameters = explode('/',trim(substr(self::$_parameters,0,stripos(self::$_parameters,'?')),'/'));
	    	self::$_parameters = array_merge(self::$_parameters,$_REQUEST,$_FILES);

	    }else{
	    	
	        self::$_controller = array_shift($arr_uri);
	        self::$_method     = "index";

	    }

	}	

	/**
	 * Descripción : Obtiene el nombre del controlador y lo retorna en caso de no estar vacío
	 * @author     : Alexis Visser <alexis_visser@hotmail.com> 03-05-2020
	 * @return     : (String | Null)
	 */
	public static function getController(){

		if(!empty(self::$_controller)){

			return self::$_controller; 

		}

		return NULL;

	}

	/**
	 * Descripción : Obtiene el nombre del método y lo retorna en caso de no estar vacío
	 * @author     : Alexis Visser <alexis_visser@hotmail.com> 03-05-2020
	 * @return     : (String | Null)
	 */
	public static function getMethod(){

		if(!empty(self::$_method)){

			return self::$_method; 

		}

		return NULL;

	}

	/**
	 * Descripción : Obtiene los parámetros pasados por request y files devolviendo los que no están vacíos
	 * @author     : Alexis Visser <alexis_visser@hotmail.com> 03-05-2020
	 * @return     : (String | Null)
	 */
	public static function getParameters(){

		if(!empty(self::$_parameters)){

			foreach(self::$_parameters as $idx => $_parameters){

				if(empty($_parameters)) unset(self::$_parameters[$idx]);

			}
			
		}

		return self::$_parameters;

	}
}
?>