<?php

class Loader{

	private static $_variables;
	private static $_js_code;
	private static $_css_code;

	public function __construct(){

		self::$_variables = [];
		self::$_js_code   = '';
		self::$_css_code  = '';

	}
	
	/**
	 * Descripción : Instancia la entidad señalada por parámetro
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 27-05-2020
	 * @param      : (String) $_path	 
	 * @return     : (Object)
	 */
	public static function dao($_class){
		
		try{

			if(preg_match('/\.php/i',$_class))	$_class = substr($_class,0,strpos($_class,'.php'));
			
			$_file  = $_class;			

			if(!preg_match('/\.php/i',$_file)) $_file .= '.php';

	        $_path = "DAO";

	        if(!is_dir($_path)) die("El directorio \"DAO\" no existe");
	        
	        $_path .= DS.$_file;

	        if(!is_readable($_path))   die("No se ha encontrado el archivo que incluye la entidad \"".$_class."\"");
	        if(!class_exists($_class)) die("No se ha podido instanciar la entidad \"".$_class."\"");

	        require_once $_path;

	        return new $_class();

	    }catch(\Exception $e){

	    	die($e->getMessage());

	    }

	}

	/**
	 * Descripción : Instancia el controlador señalado por parámetro
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 27-05-2020
	 * @param      : (String) $_path 
	 * @return     : (Object)
	 */
	public static function controller($_class){

		try{

			if(preg_match('/\.php/i',$_class))	$_class = substr($_class,0,strpos($_class,'.php'));

			$_file    = $_class;			

			if(!preg_match('/\.php/i',$_file)) $_file .= '.php';

	        $_path = "controllers";

	        if(!is_dir($_path)) die("El directorio \"controllers\" no existe");
	        
	        $_path .= DS.$_file;

	        if(!is_readable($_path))   die("No se ha encontrado el archivo que incluye la entidad \"".$_class."\"");
	        if(!class_exists($_class)) die("No se ha podido instanciar la entidad \"".$_class."\"");

	        require_once $_path;

	        return new $_class();

	    }catch(\Exception $e){

	    	die($e->getMessage());

	    }
	}

	/**
	 * Descripción : Instancia la librería señalada por parámetro
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 27-05-2020
	 * @param      : (String) $_path 
	 * @return     : (Object)
	 */
	public static function library($_class){

		try{

			if(preg_match('/\.php/i',$_class))	$_class = substr($_class,0,strpos($_class,'.php'));
			
			$_file    = $_class;		

			if(!preg_match('/\.php/i',$_file)) $_file .= '.php';	        

	        $_path = "libs";

	        if(!is_dir($_path)) die("El directorio \"libs\" no existe");
	        
	        $_path .= DS.$_file;

	        if(!is_readable($_path))   die("No se ha encontrado el archivo que incluye la entidad \"".$_class."\"");
	        if(!class_exists($_class)) die("No se ha podido instanciar la entidad \"".$_class."\"");

	        require_once $_path;

	        return new $_class();

	    }catch(\Exception $e){

	    	die($e->getMessage());

	    }

	}

	/**
	 * Descripción : Renderiza u obtiene el contenido de una vista
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 27-05-2020
	 * @param      : [opcional](String)  $_path	
	 * @param      : [opcional](Array)  $_data	
	 * @param      : [opcional](boolean) $_is_to_render	 = para renderizar la vista	  
	 * @return     : (Object)
	 */
	public static function view($_file = "", $_data = [], $_is_to_render = true){

		if(!$_is_to_render) ob_start();

		if(empty($_file) and $_is_to_render){

			$_path = "views/templates/base.php";
			if(!is_readable($_path)) die("No se ha encontrado la vista");
		}else{	

			$_path = "views/templates/";
			$_view = $_file;

			if(!preg_match('/\.php/i',$_file)){
				$_view  .= '.php';
				$_path  .= $_view;
				$_found  = true;   

				if(!is_readable($_path)) $_found = false;

			}  
			
			if(!$_found){

				$_path = "views/templates/";
				$_view = $_file;

				if(!preg_match('/\.html/i',$_file)){
					$_view  .= '.html';
					$_path  .= $_view;
					$_found  = true;   

					if(!is_readable($path)) $_found = false;
				}

			}

			if(!$_found) die("Vista no encontrada");		

		}
		
	    if(is_array(self::$_variables) and count(self::$_variables) > 0) extract(self::$_variables);
	    if(!empty($_data) and is_array($_data) && count($_data) > 0) extract($_data);
		
		require $_path;

		if(!empty($_file)){
	    	echo self::$_js_code;
	    }
		 
		if(!$_is_to_render){

	    	$content = ob_get_contents();

	    	ob_get_clean();	    	

	    	return  $content;

	    }

	    

	}

	public static function js($_javascript,$_inscrustado=0){ 

        $_path = "views/js/$_javascript";		
		
        if(filter_var('javascript://'.$_path, FILTER_VALIDATE_URL)){
	        if(!preg_match('/\.js/i',$_path)) $_path .= ".js";        

	        if(is_file($_path) and is_readable($_path)){
	        	
	        	$_fullpath  = Uri::getBaseUri().$_path;
	            $js_content = file_get_contents($_fullpath);           

	            if(strpos($_javascript,'min.js') === false){

	                $js_content = self::minify_js($js_content);

	       		}
	       		
	            self::$_js_code .= "\r\n".'<script type="text/javascript">'.$js_content.'</script>'."\r\n";

	       	}else{

	       		self::$_js_code .= "\r\n".'<script type="text/javascript">'.$_javascript.'</script>'."\r\n";
	       		
	       	} 
	    }elseif($_inscrustado){
	    	self::$_js_code .= "\r\n".'<script type="text/javascript">'.self::minify_js($_javascript).'</script>';
	    }else{
	    	$arrPath = explode('/',$_javascript); 

	       	self::$_js_code .= "\r\n".'<script type="text/javascript">console.warn("No se ha cargado '.array_pop($arrPath).'.js");</script>'."\r\n";
	    }           
           
	}

	public static function css($_css){

	}
	/**
	 * Descripción : Se definen las variables con las que se trabajarán en la vista
	 * @author     : Alexis Visser <alex_vaiser@hotmail.com> 27-05-2020
	 * @param      : (String) $variable_name
	 * @param      : (var) $container		
	 */
	public static function assign($variable_name = null,$container = null){

		if($variable_name === null)                    die("Debe definir la variable");
		if(in_array($variable_name,self::$_variables)) die("La variable \"$variable_name\" ya se encuentra definida");
	    
	    self::$_variables[$variable_name] = $container;

	}

	private static function minify_js($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                // Remove comment(s)
                '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                // Remove white-space(s) outside the string and regex
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                // Remove the last semicolon
                '#;+\}#',
                // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                '#([\{,])([\'])(\d+|[a-z_]\w*)\2(?=\:)#i',
                // --ibid. From `foo['bar']` to `foo.bar`
                '#([\w\)\]])\[([\'"])([a-z_]\w*)\2\]#i',
                // Replace `true` with `!0`
                '#(?<=return |[=:,\(\[])true\b#',
                // Replace `false` with `!1`
                '#(?<=return |[=:,\(\[])false\b#',
                // Clean up ...
                '#\s*(\/\*|\*\/)\s*#'
            ),
            array(
                '$1',
                '$1$2',
                '}',
                '$1$3',
                '$1.$3',
                '!0',
                '!1',
                '$1'
            ),
            $input);
    }


    private function minify_css($input) {
        if(trim($input) === "") return $input;
        // Force white-space(s) in `calc()`
        if(strpos($input, 'calc(') !== false) {
            $input = preg_replace_callback('#(?<=[\s:])calc\(\s*(.*?)\s*\)#', function($matches) {
                return 'calc(' . preg_replace('#\s+#', "\x1A", $matches[1]) . ')';
            }, $input);
        }
        return preg_replace(
            array(
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by a white-space or `=`, `:`, `,`, `(`, `-`
                '#(?<=[\s=:,\(\-]|&\#32;)0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][-\w]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s=:,\(]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s',
                '#\x1A#'
            ),
            array(
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2',
                ' '
            ),
            $input);
    }
}
?>