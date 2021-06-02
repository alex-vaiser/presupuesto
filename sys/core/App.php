<?php

class App{
	
	public static function init(){		

		$_request    = new Request;		
		$_controller = $_request->getController();
		$_method     = $_request->getMethod();
		$_parameters = $_request->getParameters();
		$_extension  = '.php';			
		$_class      = $_controller;

        if(!preg_match('/\.php/i',$_controller)){
            $_controller .= $_extension;
        }        
        
		$path = "controllers" . DS . $_controller;

		if(!is_readable($path)) die("Error en la ruta");

		require_once $path;

		if(!class_exists($_class)) die("No se ha encontrado el controlador".$_controller);
		
		$controller = new $_class;	

		if(!is_callable(array($controller,$_method))) die("m&eacute;todo no encontrado");
		
		if(!empty($_parameters)){
			call_user_func_array(array($controller,$_method),$_parameters);
		}else{
			call_user_func(array($controller,$_method));
		}	
		
	}
	
}

?>