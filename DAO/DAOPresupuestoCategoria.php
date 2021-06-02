<?php
	class DAOPresupuestoCategoria extends DAO{

		protected $_table;
		protected $_primary_key;

		public function __construct(){
			parent::__construct();

			$this->_table       = "tb_presupuesto_categoria";
			$this->_primary_key = "id";
		}

		public function getList(){
			$query  = "SELECT * FROM $this->_table WHERE bool_estado = 1";
			$result = $this->setQuery($query)->runQuery()->getResult();

			if($result->rowCount > 0){
				return $result->rows;
			}
			return false;
		}
	}
?>