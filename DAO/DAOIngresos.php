<?php	
	class DAOIngresos extends DAO{
		
		protected $_table;
		protected $_primary_key;

		public function __construct(){
			parent::__construct();

			$this->_table       = "tb_ingresos";
			$this->_primary_key = "id";
		}

		public function getTotal(){
			$query  = "SELECT SUM(monto) AS total FROM $this->_table";
			$result = $this->setQuery($query)->runQuery()->getResult(0);

			if($result->rowCount > 0){
				return $result->rows->total;
			}
			return 0;			
		}

		public function getList(){
			$query  = "SELECT DATE_FORMAT(fecha_registro,'%d/%m/%Y') AS fecha,
							  DATE_FORMAT(fecha_registro,'%H:%i:%s') AS hora,
							  fecha_registro AS fecha_hora_sin_formato,
							  monto
			           FROM $this->_table";
			$result = $this->setQuery($query)->runQuery()->getResult();

			if($result->rowCount > 0){
				return $result->rows;
			}
			return false;			
		}

		public function getTotalMes(){
			$query = "SELECT IFNULL(SUM(monto),0) AS total_mes
					  FROM $this->_table
					  WHERE DATE_FORMAT(fecha_registro,'%c') = DATE_FORMAT(NOW(),'%c')";
			$result = $this->setQuery($query)->runQuery()->getResult(0);

			return $result->rows->total_mes; 
		}

		
	}
?>