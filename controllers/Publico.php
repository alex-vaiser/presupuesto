<?php

class Publico extends Controller{
	
    protected $_ctrlIngreso;

	public function __construct(){
		parent::__construct();
        
        $this->_ctrlIngreso     = $this->load->controller("Ingreso");
        $this->_ctrlPresupuesto = $this->load->controller("Presupuesto");
        $this->_ctrlMenu        = $this->load->controller("Menu");
        $this->_daoUsuario      = $this->load->dao("DAOUsuario");
	}

	public function index(){

        if(empty($_SESSION["id_user"])){
            header("Location:".Uri::getBaseUri()."Publico/Login");
        }

		$data = [
                    "datos" => [
                                    "ctrlingresos"    => $this->_ctrlIngreso->init(),
                                    "ctrlpresupuesto" => $this->_ctrlPresupuesto->init()
                                ],
                    "meses" => [
                                    '1'  => "ENERO", 
                                    '2'  => "FEBRERO", 
                                    '3'  => "MARZO", 
                                    '4'  => "ABRIL", 
                                    '5'  => "MAYO", 
                                    '6'  => "JUNIO", 
                                    '7'  => "JULIO", 
                                    '8'  => "AGOSTO",
                                    '9'  => "SEPTIEMBRE", 
                                    '10' => "OCTUBRE", 
                                    '11' => "NOVIEMBRE", 
                                    '12' => "DICIEMBRE" 
                                ],
                    "menu"  => $this->_ctrlMenu->getList()
                ];
                
		$html = $this->load->view("containers/container_public_main",$data,0);

        $this->load->js("templates/ingresos");
        $this->load->js("templates/presupuesto");        
		$this->load->assign("contained",$html);
		$this->load->view();
	}

    public function login(){
        $html = $this->load->view("containers/container_login",'',0);
        $this->load->js("templates/usuario");
        $this->load->assign("contained",$html);
        $this->load->view();
    }

    public function autenticar(){
        $params  = $this->request->getParameters();
        $user    = $params["input_usuario"];
        $pass    = $params["input_clave"];
        $mensaje = "";
        $error   = false;

        if(empty($user)){
            $mensaje .= "- Debe ingresar usuario<br>";
            $error   = true;
        }

        if(empty($pass)){
            $mensaje .= "- Debe ingresar contraseña<br>";
            $error   = true;
        }

        if($error){
            die(json_encode(["error"=>$error,"mensaje"=>$mensaje]));
        }else{
            $pass_enc = hash("sha512",$pass,false);
            $id_user  = $this->_daoUsuario->isUserValid($user,$pass_enc); 

            if($id_user){
                $_SESSION["id_user"] = $id_user;
                echo json_encode(["error"=>$error,"url"=>Uri::getBaseUri()."Publico"]);
            }
        }
    }

    public function cerrarSession(){
        session_destroy();
        header("Location:".Uri::getBaseUri()."Publico/Login");
    }


	public static function redimensionar_imagen($nombreimg, $rutaimg, $xmax, $ymax){  
        $ext = explode(".", $nombreimg);  
        $ext = $ext[count($ext)-1];  
      
        if($ext == "jpg" || $ext == "jpeg")  
            $imagen = imagecreatefromjpeg($rutaimg);  
        elseif($ext == "png")  
            $imagen = imagecreatefrompng($rutaimg);  
        elseif($ext == "gif")  
            $imagen = imagecreatefromgif($rutaimg);  
          
        $x = imagesx($imagen);  
        $y = imagesy($imagen);  
          
        if($x <= $xmax && $y <= $ymax){
            //echo "<center>Esta imagen ya esta optimizada para los maximos que deseas.<center>";
            return $imagen;  
        }
      
        if($x >= $y) {  
            $nuevax = $xmax;  
            $nuevay = $nuevax * $y / $x;  
        }  
        else {  
            $nuevay = $ymax;  
            $nuevax = $x / $y * $nuevay;  
        }  
          
        $img2 = imagecreatetruecolor($nuevax, $nuevay);  
        imagecopyresized($img2, $imagen, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);  
        //echo "<center>La imagen se ha optimizado correctamente.</center>";
        return $img2;   
    }

}
?>