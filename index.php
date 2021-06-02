<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", false);

require_once __DIR__ . DIRECTORY_SEPARATOR . "sys" . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "Constant.php";
require_once __DIR__ . DS . "libs"     . DS . "File.php";
require_once __DIR__ . DS . "libs"     . DS . "Uri.php";
require_once __DIR__ . DS . "libs"     . DS . "Funcion.php";
require_once __DIR__ . DS . "libs"     . DS . "Email.php";
require_once __DIR__ . DS . "libs"     . DS . "Pdf.php";
require_once __DIR__ . DS . "sys" . DS . "database" . DS . "Connection.php";
require_once __DIR__ . DS . "sys" . DS . "database" . DS . "QueryBuilder.php";
require_once __DIR__ . DS . "sys" . DS . "core"     . DS . "Loader.php";
require_once __DIR__ . DS . "sys" . DS . "core"     . DS . "Request.php";
require_once __DIR__ . DS . "sys" . DS . "core"     . DS . "App.php";
require_once __DIR__ . DS . "sys" . DS . "core"     . DS . "DAO.php";
require_once __DIR__ . DS . "sys" . DS . "core"     . DS . "Controller.php";
require_once __DIR__ . DS . "sys" . DS . "core"     . DS . "Autoloader.php";

try{
	
	spl_autoload_register('Autoloader::loader');
	App::init();
	
}catch(Exception $e){
	die($e->getMessage());
}
?>