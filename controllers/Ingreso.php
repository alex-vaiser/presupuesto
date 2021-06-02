<?php

	class Ingreso extends Controller{
		
		protected $_daoIngreso;
		protected $_ctrlPresupuesto;

		public function __construct(){
			parent::__construct();

			$this->_daoIngreso      = $this->load->dao("DAOIngresos");
			$this->_ctrlPresupuesto = $this->load->controller("Presupuesto");

		}

		public function init(){
			
			$datos = [
						"resumen" => [
										"total" => $this->_ctrlPresupuesto->getSaldoIngreso()
						             ],
						"listado" => [
										"ingresos" => $this->_daoIngreso->getList()
									 ]
					 ];

			return $datos;
			
		}

		public function guardar(){
			$params    = $this->request->getParameters();
			$nr_monto  = $params["nr_monto"];
			$respuesta = json_encode(["correcto"=>false,"mensaje"=>"Debe ingresar monto"]);

			if(!empty($nr_monto)){
				$datos = [
							"monto"          => $nr_monto,
							"fecha_registro" => date("Y-m-d H:i:s")
						 ];
				$registrado = $this->_daoIngreso->create($datos);
				if($registrado){
					$respuesta = json_encode([
												"correcto"     => true,
												"mensaje"      => "Ingreso registrado con &eacute;xito",
												"cargarGrilla" => $this->cargarGrilla(),
												"datos"        => $this->init()
											]);
				}
			}

			echo $respuesta; 
		}

		public function cargarGrilla(){
			$this->load->assign("datos",["ctrlingresos"=>$this->init()]);
			$this->load->js("Base.cargarDataTable('table_ingresos',1,'desc');",1);
			$html = $this->load->view("grids/table_ingresos",'',0);
			return $html;
		}
	}
?>