<?php
	class DAOPresupuestoItem extends DAO{
		protected $_table;
		protected $_primary_key;

		public function __construct(){
			parent::__construct();

			$this->_table       = "tb_presupuesto_item";
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

		public function isCerrado($folio){
			
			$params     = explode('-',$folio);

			$query = " SELECT is_cerrado 
			           FROM tb_presupuesto
			           WHERE id_mes       = ?
			           AND id_anio        = ?
			           AND id_correlativo = ? ";

			return $this->setQuery($query,$params)->runQuery()->getResult(0)->rows->is_cerrado;

		}

		public function getList($nro_folio = "",$tipo = ""){
			$params     = explode('-',$nro_folio);
			
			$is_cerrado = $this->isCerrado($nro_folio);

			$query  = "SELECT pi.id,
							  pc.nombre AS nombre_categoria,
							  psc.nombre AS nombre_subcategoria,
							  pi.monto_mes_anterior,
							  pi.monto_mes_actual,
							  (pi.monto_mes_actual - (SELECT IFNULL(SUM(monto),0) FROM tb_presupuesto_gasto_item WHERE id_presupuesto_item = pi.id)) AS saldo
			           FROM $this->_table pi 
			           LEFT JOIN tb_presupuesto_categoria pc ON pc.id = pi.id_categoria
			           LEFT JOIN tb_presupuesto_sub_categoria psc ON psc.id = pi.id_sub_categoria
			           WHERE pi.id_mes = ?
			           AND pi.id_anio = ?
			           AND pi.id_correlativo = ?";
			
			if(($tipo == 1 && !$is_cerrado) || ($tipo == 2 && $is_cerrado)){
				$result = $this->setQuery($query,$params)->runQuery()->getResult();

				if($result->rowCount > 0){
					return $result->rows;
				}
			}
			return [];			
		}

		public function getMontoMesAnteriorBySubCategoria($id_subcategoria){
			$meses = [
						'1'  => "Enero",
						'2'  => "Febrero",
						'3'  => "Marzo",
						'4'  => "Abril",
						'5'  => "Mayo",
						'6'  => "Junio",
						'7'  => "Julio",
						'8'  => "Agosto",
						'9'  => "Septiembre",
						'10' => "Octubre",
						'11' => "Noviembre",
						'12' => "Diciembre"
					];
			$mesAnterior = ((date(n)-1) == 0) ? $meses['12'] : $meses[date(n)-1];			
			$query  = "SELECT IFNULL(SUM(monto_mes_actual),0) AS monto_mes_anterior FROM $this->_table WHERE id_sub_categoria = ? AND mes_actual = ?";
			$params = [$id_subcategoria,$mesAnterior];
			
			return $this->setQuery($query,$params)->runQuery()->getResult(0)->rows->monto_mes_anterior;
			
		}

		public function getTotalByFolio($folio){
			$params   = explode("-",$folio);
			$query 	  = " 	SELECT SUM(monto_mes_actual) AS total
			         		FROM $this->_table
			         		WHERE id_mes = ? AND id_anio = ? AND id_correlativo = ?";
			$result = $this->setQuery($query,$params)->runQuery()->getResult(0);

			return $result->rows->total;
		}

		public function getTotalMes(){
			$query = "SELECT IFNULL(SUM(monto_mes_actual),0) AS total_mes
					  FROM $this->_table
					  WHERE id_mes = DATE_FORMAT(NOW(),'%c')";
			$result = $this->setQuery($query)->runQuery()->getResult(0);

			return $result->rows->total_mes; 
		}


		public function getTotalItem($folio,$item){
			
			$params   = explode('-',$folio);
			$params[] = $item;

			$query = " SELECT monto_mes_actual
			           FROM $this->_table
			           WHERE id_mes = ?
			           AND id_anio = ? 
			           AND id_correlativo = ?
			           AND id_sub_categoria = ?";

			$result = $this->setQuery($query,$params)->runQuery()->getResult(0)->rows->monto_mes_actual;

			if($result){
				return $result;
			}

			return 0;
		}
	}
?>