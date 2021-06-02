<?php 
	class Presupuesto extends controller{
		
		protected $_daoPresupuestoCategoria;
		protected $_daoPresupuestoSubCategoria;
		protected $_daoPresupuestoGastoItem;
		protected $_daoPresupuestoItem;
		protected $_daoPresupuesto;
		protected $_daoIngreso;

		public function __construct(){
			parent::__construct();

			$this->_daoPresupuestoCategoria    = $this->load->dao("DAOPresupuestoCategoria");
			$this->_daoPresupuestoSubCategoria = $this->load->dao("DAOPresupuestoSubCategoria");
			$this->_daoPresupuestoItem         = $this->load->dao("DAOPresupuestoItem");
			$this->_daoPresupuestoGastoItem    = $this->load->dao("DAOPresupuestoGastoItem");
			$this->_daoPresupuesto             = $this->load->dao("DAOPresupuesto");
			$this->_daoIngreso                 = $this->load->dao("DAOIngresos");
		}

		public function init(){
			
			$datos = [
						"resumen" => [
										"total_mes" => $this->getSaldoPresupuesto()
						             ],
						"listado" => [
										"categorias"       => $this->_daoPresupuestoCategoria->getList(),
										"subcategoria"     => $this->_daoPresupuestoSubCategoria->getList(),
										"presupuesto"      => $this->_daoPresupuesto->getList()			
									 ]
					 ];

			return $datos;

		}

		public function nuevo(){			
			$folio = $this->_daoPresupuesto->getFolio();
           	echo json_encode(["folio"=>$folio,"cargarGrilla"=>$this->cargarGrilla()]);
		}

		public function getListSubCategoriaByCategoria(){

			$params           = $this->request->getParameters();
			$id_categoria     = $params["id_categoria"];
			$listSubCategoria = $this->_daoPresupuestoSubCategoria->getList($id_categoria);

			echo json_encode(["listadoCategorias"=>$listSubCategoria]);
		}

		public function guardarItem(){
			
			$params   = $this->request->getParameters();
			$arrFolio = explode('-',$params["input_folio"]);
			$saldo    = $this->getSaldoIngreso();
			
			if($params["select_categoria"] == 0 or $params["select_subcategoria"] == 0){
				die(json_encode(["correcto"=>false,"mensaje"=>"Debe seleccionar Categoría y/o Sub-categoria"]));
			}

			if($params["input_monto_presupuesto_actual"] > $params["nr_total_ingresos"] || $saldo <= 0){
				die(json_encode(["correcto"=>false,"mensaje"=>"No hay saldo suficiente para agregar el ítem <br> Su saldo total disponible es de $ $saldo.-"]));
			}

			$monto_item = $this->_daoPresupuestoItem->getTotalItem($params["input_folio"],$params["select_subcategoria"]);
			
			if($monto_item){
				$presupuesto_item = [
										"monto_mes_actual" => ($monto_item + $params["input_monto_presupuesto_actual"])
									];
				$id_presupuesto_detalle = $this->_daoPresupuestoItem->modify($presupuesto_item,"id_mes=$arrFolio[0] AND id_anio=$arrFolio[1] AND id_correlativo=$arrFolio[2] AND id_sub_categoria = $params[select_subcategoria]");

			}else{

				$presupuesto_item = [
										"id_mes"             => $arrFolio[0],
										"id_anio"            => $arrFolio[1],
										"id_correlativo"     => $arrFolio[2],
										"id_categoria"       => $params["select_categoria"],
										"id_sub_categoria"   => $params["select_subcategoria"],
										"monto_mes_anterior" => $params["input_monto_presupuesto_anterior"],
										"monto_mes_actual"   => $params["input_monto_presupuesto_actual"],
										"mes_anterior"       => $params["input_mes_anterior"],
										"mes_actual"         => $params["input_mes_actual"]
									 ];

				$id_presupuesto_detalle = $this->_daoPresupuestoItem->create($presupuesto_item);
			}
			
			if($id_presupuesto_detalle){
				$fnCargarGrillaItems = $this->cargarGrillaItems($params["input_folio"]);
				echo json_encode([
									"correcto"          => true,
									"mensaje"           => "",
									"cargarGrillaItems" => $fnCargarGrillaItems->html,
									"cantidadItems"     => $fnCargarGrillaItems->cantidadItem,
									"cargarGrilla"      => $this->cargarGrilla(),
									"resumen"           => [
																"total_ingresos_mes"    => $this->getSaldoIngreso(),
																"total_presupuesto_mes" => $this->getSaldoPresupuesto()
									                       ]
								]);
			}else{
				echo json_encode(["correcto"=>false]);
			}
		}

		public function cargarGrillaItems($folio,$tipo=1){
			if(!empty($folio)){
				$items  = $this->_daoPresupuestoItem->getList($folio,$tipo);
				$gastos = [];

				if($this->_daoPresupuestoItem->isCerrado($folio)){
					$gastos = $this->_daoPresupuestoGastoItem->getList($folio);
				}
				
				$this->load->assign("datos",[
												"ctrlpresupuesto"=>[
																	"listado"=>[
																					"presupuesto_item"=>$items,
																					"presupuesto_gastos"=>$gastos
																			   ]
																	]
									        ]);
			}else{
				$items = [];
				$this->load->assign("datos",[]);
			}

			switch($tipo){
				case 1:
					$this->load->js("Base.cargarDataTable('table_presupuesto_item',0,'desc');",1);
					$html = $this->load->view("grids/table_presupuesto_item",'',0);
					break;
				case 2:
					$this->load->js("Base.cargarDataTable('table_gasto_item');",1);
					$this->load->js("Base.cargarDataTable('table_gasto');",1);
					$html  = $this->load->view("grids/table_gastos_item",'',0);
					$html2 = $this->load->view("grids/table_gastos",'',0);

					break;
			}
			return (Object)["html"=>$html,"html2"=>$html2,"cantidadItem"=>count($items)];
		}

		public function cargarGrilla(){
			
			$this->load->assign("datos",[
											"ctrlpresupuesto"=>[
																"listado"=>[
																				"presupuesto"=>$this->_daoPresupuesto->getList()
																		   ]
																]
								        ]);
			$this->load->js("Base.cargarDataTable('table_presupuesto',0,'desc');",1);
			$html = $this->load->view("grids/table_presupuesto",'',0);
			return $html;
		}

		public function get(){
			$param  = $this->request->getParameters();
			$folio  = $param["folio"];
			$tipo   = (!empty($param["tipo"]))?$param["tipo"]:1;

			switch($tipo){
				case 1:
					$fnCargarGrillaItems = $this->cargarGrillaItems($folio);
					break;
				default:
					$fnCargarGrillaItems  = $this->cargarGrillaItems($folio,$tipo);
					

			}
			echo json_encode(["cargarGrillaItems"=>$fnCargarGrillaItems->html,"cantidadItems"=>$fnCargarGrillaItems->cantidadItem,"cargarGrillaGastos"=>$fnCargarGrillaItems->html2]);
		}

		public function getMontoAnteriorBySubCategoria(){
			$param        = $this->request->getParameters();
			$subcategoria = $param["subcategoria"];
			$monto        = $this->_daoPresupuestoItem->getMontoMesAnteriorBySubCategoria($subcategoria);

			echo json_encode(["montoAnterior"=>$monto]);
		}

		public function verificarAbierto(){
			$presupuestos = json_decode(json_encode($this->_daoPresupuesto->getList()),1);
			
			if(in_array(0,array_column($presupuestos,"is_cerrado"))){
				echo json_encode(["bo_abierto" => 1]);
			}else{
				echo json_encode(["bo_abierto" => 0]);
			}
		}

		public function finalizar(){
			$param    = $this->request->getParameters();
			$arrFolio = explode("-",$param["folio"]);

			$modificated = $this->_daoPresupuesto->modify(["is_cerrado"=>1,"monto_total"=>$this->_daoPresupuestoItem->getTotalByFolio($param["folio"])],"id_mes=$arrFolio[0] AND id_anio=$arrFolio[1] AND id_correlativo=$arrFolio[2]");
			
			if($modificated){
				echo json_encode(["correcto"=>true,"cargarGrillaItems"=>$this->cargarGrillaItems(""),"cargarGrilla"=>$this->cargarGrilla()]);
			}else{
				echo json_encode(["correcto"=>false,"cargarGrillaItems"=>"","cargarGrilla"=>""]);
			}
		}

		public function getSaldoIngreso(){
			return $this->_daoIngreso->getTotalMes() - $this->_daoPresupuestoItem->getTotalMes();
		}

		public function getSaldoPresupuesto(){
			return $this->_daoPresupuestoItem->getTotalMes() - $this->_daoPresupuestoGastoItem->getTotalMes();
		}

		public function eliminarItem(){
			$params   = $this->request->getParameters();
			$deleted = $this->_daoPresupuestoItem->delete($params["id_item"]); 

			if($deleted){
				$fnCargarGrillaItems = $this->cargarGrillaItems($params["folio"]);				 
				echo json_encode([									
									"cargarGrillaItems" => $fnCargarGrillaItems->html,
									"cantidadItems"     => $fnCargarGrillaItems->cantidadItem,
									"cargarGrilla"      => $this->cargarGrilla(),
									"resumen"           => [
																"total_ingresos_mes"    => $this->getSaldoIngreso(),
																"total_presupuesto_mes" => $this->getSaldoPresupuesto()
									                       ]
								]);
			}
		}

		public function modalEmail(){	
			$params = $this->request->getParameters();
			$folio  = str_replace('-','',$params["folio"]);
			$items  = $this->_daoPresupuestoItem->getList($params["folio"],2);

			$this->load->assign("arrPresupuestoItems",$items);		
			$this->load->assign("folio",$params["folio"]);		
			$this->load->js("
								$(document).ready(function(){
									$('#nro_presupuesto').html(".$folio.");
									$('#input_nombre_dest').on('blur',function(){	
										if(this.value == ''){
											VentanaModal.error('Debe ingresar el nombre del destinatario');
										}else{
											$('#nombre_destinatario').html($(this).val());									
										}								
									});
									$('#input_email').on('blur',function(){									
										if(this.value == ''){
											VentanaModal.error('Debe ingresar el email de destinatario');								
										}else if(!Base.validarEmail(this.value)){
											VentanaModal.error('El Email es inv&aacute;lido');								
										}
									});
								});
							",1);
			$this->load->view("modal/modal_email");
		}

		public function enviarEmail(){
			$params = $this->request->getParameters();
			$items  = $this->_daoPresupuestoItem->getList($params["folio"]);

			$this->load->assign("nombre_destinatario",$params["nombre_destinatario"]);
			$this->load->assign("nro_presupuesto",$params["folio"]);
			$this->load->assign("arrPresupuestoItems",$items);

			$html = $this->load->view("emails/email_presupuesto","",0);

			$sended = Email::send([$params["email_destinatario"]],"Presupuesto #$params[folio]",$html);

			if($sended){
				echo json_encode(["correcto"=>true,"mensaje"=>"Presupuesto enviado con &eacute;xito"]);
			}

		}

		public function guardarGastoItem(){
			$params  = $this->request->getParameters();
			$arrData = [
						 "id_presupuesto_item" => $params["id_presupuesto_item"],
						 "monto"               => $params["monto"]
					   ];
		    $id_presupuesto_gasto_item = $this->_daoPresupuestoGastoItem->create($arrData);
		    $fnCargarGrillaItems       = $this->cargarGrillaItems($params["folio"],2);

		    if($id_presupuesto_gasto_item){
		    	echo json_encode([
		    						"cargarGrillaItems"  => $fnCargarGrillaItems->html,
		    						"cargarGrillaGastos" => $fnCargarGrillaItems->html2,
		    						"cantidadItems"      => $fnCargarGrillaItems->cantidadItem,
		    						"resumen"            => [															
																"total_presupuesto_mes" => $this->getSaldoPresupuesto()
									                        ]
		    					]);
		    }else{

		    }
		}
	}
?>