<?php
	class DAOPresupuestoSubCategoria extends DAO{

		protected $_table;
		protected $_primary_key;

		public function __construct(){
			parent::__construct();

			$this->_table       = "tb_presupuesto_sub_categoria";
			$this->_primary_key = "id";
		}

		public function getList($id_categoria = null){
			$query  = " SELECT psc.id,
							   psc.nombre
						FROM $this->_table psc
						LEFT JOIN tb_presupuesto_categoria pc ON psc.id_categoria = pc.id
						WHERE psc.bool_estado = 1
					  ";
		    $params = [];

			if(!empty($id_categoria)){
				$query .= " AND psc.id_categoria = ? ";
				$params = [$id_categoria];
			}
			//print_r($query);die;
			$result = $this->setQuery($query,$params)->runQuery()->getResult();

			if($result->rowCount > 0){
				return $result->rows;
			}
			return false;
		}
	}
?>