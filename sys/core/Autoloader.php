<?php

class Autoloader{

	private static $directories =  	[
										"controllers",
										"DAO",
										"libs"
								   	];
	/**
	 * Descripción : Realiza la carga de archivos en forma automática
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 16-05-2020
	 * @param      : (String) $path
	 * @param      : [opcional] (String) $content
	 * @param      : [opcional] (int) $mode = Se define los permisos del directorio
	 * @return     : (Boolean)
	 */
	public static function loader($classname){
		
		$_class    = explode("\\",$classname);
		$_class    = end($_class);
		$_request  = new Request;		

		if(!preg_match('/\.php/i',$_class)){
            $_class .= '.php';
        }

		foreach(self::$directories as $directory){
			
			$_pathfull  = $directory . DS . $_class;			

			if(is_dir($directory) && is_file($_pathfull)){

				require_once $_pathfull;

			}

		}
		
	}

}
?>