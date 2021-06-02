<?php

class File{
	
	/**
	 * Descripción : Verifica sí el directorio existe
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (String) $path
	 * @return     : (Boolean)
	 */
	public static function directoryExists($path){

		$response = false;

		if(!empty($path)){

			if(is_dir($path)){

				$response = true;

			}

		}

		return $response;

	}

	/**
	 * Descripción : Verifica sí el archivo existe
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (String) $path
	 * @return     : (Boolean)
	 */
	public static function fileExists($path){

		$response = false;

		if(!empty($path)){

			if(file_exists($path)){

				$response = true;

			}

		}

		return $response;

	}

	/**
	 * Descripción : Crea el directorio según los permisos por defecto o seteados en la variable $mode
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (String) $path
	 * @param      : [opcional] (int) $mode = Se define los permisos del directorio
	 * @return     : (Boolean)
	 */
	public static function createDirectory($path,$mode = 0777){

		if(!empty($path)){
			
			$ok = mkdir($path,$mode);
			chmod($path,$mode);

			$path .= "/index.html";

			self::createFile($path);

		}

	}

	/**
	 * Descripción : Crea el archivo según los permisos por defecto o seteados en la variable $mode
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (String) $path
	 * @param      : [opcional] (String) $content
	 * @param      : [opcional] (int) $mode = Se define los permisos del directorio
	 * @return     : (Boolean)
	 */
	public static function createFile($path,$content = "",$mode = 0664){
		
		if(!empty($path)){
			
			if(empty($content)){

				$content = "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";

			}

			$file = fopen($path,'w');

			if($file){

				chmod($path,0777); 

				$written = fwrite($file,$content);

				if($written){
					chmod($path,$mode);
				}

				fclose($file);

			}

		}

	}	

	/**
	 * Descripción : Lee el contenido de un arhivo ya sea seteado como array $_FILES o por String ruta  y devuelve el valor como base 64 o el contenido sin codificar dependiendo si la variable $in_base_64 = true o false
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (array | String) $file_path
	 * @param      : [opcional] (boolean) $in_base_64 = Se define la salida sí es por base 64 o no
	 * @return     : (String | base 64)
	 */
	public static function readFile($file_path,$in_base_64=false){
		
		$content = NULL;

		if(!empty($file_path)){
			
			if(is_array($file_path)){

				if(isset($file_path["tmp_name"])){

					$file = fopen($file_path["tmp_name"],"r+b");

					if($file){
						$content = fread($file,filesize($file_path["tmp_name"]));
					}

					fclose($file);

				}

			}else{

				if(self::fileExists($file_path)){

					$file = fopen($file_path,"r+b");

					if($file){
						$content = fread($file,filesize($file_path));
					}

					fclose($file);

				}
			}

		}

		if($in_base_64){

			return base64_encode($content);

		}

		return $content;

	}

	/**
	 * Descripción : Transfiere un archivo desde una ubicación a otra y opcionalmente le coloca otro nombre sí es que está seteado la variable $new_name
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (String) $old_path
	 * @param      : (String) $new_path
	 * @param      : [opcional] (String) $new_name = Nombre que se le colocará al archivo
	 * @return     : (array) Con un booleano que indica sí se efectuo o no la trasferencia y la nueva ruta del archivo
	 */
	public static function transferFile($old_path,$new_path,$new_name = ""){

		$response = ["correct"=>false,"new_path"=>""];
		
		
		if(!empty($old_path) && !empty($new_path)){

			if(self::fileExists($old_path)){
				
				$directory_path       = explode('/',$new_path);
				array_pop($directory_path);				
				$directory_path       = implode('/',$directory_path);			 

				if(!self::directoryExists($directory_path)){					
		
					self::createDirectory($directory_path);

				}

				if(substr(sprintf('%o', fileperms($directory_path)), -4) !== 0777){
					chmod($directory_path,0777);
				}

				if(!empty($new_name)){
					$new_path = $directory_path.'/'.$new_name;
				}

				$response["new_path"] = $new_path;
				$response["correct"]  = copy($old_path,$new_path);

				if($response){
					self::deleteFile($old_path);
				}

			}
		}

		return $response;

	}

	/**
	 * Descripción : Elimina el archivo  de la ubicación pasada por parámetros
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 29-04-2020
	 * @param      : (String) $path	 
	 * @return     : (Boolean)
	 */
	public static function deleteFile($path){
		
		$response = false;

		if(!empty($path)){

			if(self::fileExists($path)){
				$response = unlink($path); 
			}

		}

		return $response;

	} 	

	/**
	 * Descripción : Obtiene permisos de la carpeta o archivo
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 15-05-2020
	 * @param      : (String) $path
	 * @return     : (int | boolean)
	 */
	public static function getPermission($path){

		if(empty($path)) return false;

		return substr(sprintf('%o', fileperms($path)), -4);

	}

	/**
	 * Descripción : Escribe en el archivo señalado a continuación de lo último escrito
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 16-05-2020
	 * @param      : (String) $path
	 * @param      : [opcional] (String) $content
	 * @param      : [opcional] (int) $mode = Se define los permisos del directorio
	 * @return     : (Boolean)
	 */
	public static function writeFile($path,$content = "",$mode = 0664){

		$file = fopen($path,'a');

		if($file){

			chmod($path,0777);

			$written = fwrite($file,$content);

			if($written){
				chmod($path,$mode);
			}

			fclose($file);

		}
	}
	
}
?>