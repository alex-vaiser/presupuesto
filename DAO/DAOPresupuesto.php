<?php
	class DAOPresupuesto extends DAO{
		protected $_table;
		protected $_primary_key;

		public function __construct(){
			parent::__construct();

			$this->_table       = "tb_presupuesto";
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

		public function getFolio(){
			
			$query  = "SELECT CONCAT(id_mes,'-',id_anio,'-',id_correlativo) AS folio,
							  CONCAT(id_mes,id_anio) AS base,
							  MAX(id_correlativo) 
					   FROM $this->_table
					   WHERE bool_estado = 0;
					  ";
			$result = $this->setQuery($query)->runQuery()->getResult(0);

			if(!empty($result->rows->folio)){			
				return $result->rows->folio;
			}

			$query = "SELECT COUNT(*) AS correlativo FROM $this->_table WHERE id_mes = '".date("n")."' AND id_anio = '".date("y")."'";	
			$correlativo = $this->setQuery($query)->runQuery()->getResult(0)->rows->correlativo + 1;			
			
			$query = "INSERT INTO $this->_table (id_mes,id_anio,id_correlativo) VALUES(DATE_FORMAT(NOW(),'%c'),DATE_FORMAT(NOW(),'%y'),$correlativo)";
			$this->setQuery($query)->runQuery();
			return $this->getFolio(); 
		} 

		public function getList(){
			$query  = "SELECT 
							  CONCAT(p.id_mes,'-',p.id_anio,'-',p.id_correlativo) AS folio,	
							  DATE_FORMAT(p.fecha_registro,'%d/%m/%Y') AS fecha,
							  DATE_FORMAT(p.fecha_registro,'%H:%i:%s') AS hora,
							  p.fecha_registro AS fecha_hora_sin_formato,							  
							  IFNULL(IFNULL(monto_total,(SELECT SUM(monto_mes_actual) FROM tb_presupuesto_item WHERE id_mes = p.id_mes AND id_anio = p.id_anio AND id_correlativo = p.id_correlativo)),0) AS monto_total,
							  p.is_cerrado
			           FROM $this->_table p";
			$result = $this->setQuery($query)->runQuery()->getResult();

			if($result->rowCount > 0){
				return $result->rows;
			}
			return false;			
		}

		
		
	}	
?>