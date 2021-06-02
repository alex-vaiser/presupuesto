<?php

	class Connection{

		private $_instance_mysql;

		public function __construct(){

			$json    	= 	json_decode(CFG_JSON,1);
			$options 	= 	[
								PDO::ATTR_PERSISTENT         => FALSE,
								PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		           			];

		    if($json){

			    switch($json["typeAmbient"]){
			    	case "local":
			    		$db_server   = $json["dataBase"]["local"]["server"];
			    		$db_port     = $json["dataBase"]["local"]["port"];
			    		$db_name     = $json["dataBase"]["local"]["database"]; 
			    		$db_charset  = $json["dataBase"]["local"]["charset"]; 
			    		$db_user     = $json["dataBase"]["local"]["user"];
			    		$db_password = $json["dataBase"]["local"]["password"];
			    		break;
			    	case "production":
			    		$db_server   = $json["dataBase"]["production"]["server"];
			    		$db_port     = $json["dataBase"]["production"]["port"];
			    		$db_name     = $json["dataBase"]["production"]["database"]; 
			    		$db_charset  = $json["dataBase"]["production"]["charset"]; 
			    		$db_user     = $json["dataBase"]["production"]["user"];
			    		$db_password = $json["dataBase"]["production"]["password"];
			    		break;
			    }
			    //die('<pre>'.print_r($json["dataBase"]["local"],true).'</pre>');
			    try{

			    	if(!$this->isConnected()){
			    		$this->_instance_mysql = new PDO("mysql:host=".$db_server.";port=".$db_port.";dbname=".$db_name.";charset=".$db_charset,$db_user,$db_password,$options);
			   		}

			    }catch(PDOExeption $e){
			    	
			    	die("No fue posible realizar la conexi&oacute;n con la base de datos");
			   
			   }

			}

		}

		public function isConnected(){		

			if($this->_instance_mysql){

				return true;

			}

			return false;

		}

		public function getInstance(){			
			
			return $this->_instance_mysql;
			
		}

		public function closeConnection(){

			$this->_instance_mysql = "";

		}


	}
?>