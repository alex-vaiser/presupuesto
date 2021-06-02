<?php
	
	class QueryBuilder{

		protected $_table;
		protected $_primary_key;
		protected $_db;
		private   $_query;
		private   $_params;

		public function __construct(){

			$this->_db = new Connection;

		}

		public function setQuery($query = null, $params = null){

			if(is_null($query)) die("Debe ingresar una query en \"setQuery\"");

			if(!is_null($params)){

				$this->_params = $params;

			} 
				
			$this->_query = $this->_db->getInstance()->prepare($query);

			return $this;
			
		}

		public function runQuery(){

			if(empty($this->_query)) die("Está intentando correr una query que no existe");

			try{

				if(!empty($this->_params) && is_array($this->_params)){

					$this->_query->execute($this->_params);

				}else{

					$this->_query->execute();

				}

				return $this;

			}catch(\PDOException $e){

				die($e->getMessage());

			}		

		}

		public function getResult($index = null){
		
			$rows = $this->_query->fetchAll();

			if(is_numeric($index)){

				$rows = $rows[$index];

			}

			return (object) array("rows" => $rows, "rowCount" => count($rows));

		}

		public function isRowAffected(){

			return $this->_query->rowCount() > 0;

		}

		public function create($params = []){

			if(empty($params))     die("Está intentando ejecutar la funcion \"create\" sin parámetros");
			if(!is_array($params)) die("Debe ingresar un arreglo asociativo, cuyas claves deben ser el nombre de los campos de la tabla \"$this->_table\" en la función \"create\"");
			
			$params = $this->deleteNull($params);
			$fields = implode(',',array_keys($params));
			$params = array_values($params);
			$values = trim(str_repeat("?,", count($params)),',');		
			$query  = "INSERT INTO $this->_table($fields) VALUES($values)";
			
			$this->setQuery($query,$params)->runQuery();

			return $this->getLastInsertId();

		}

		public function modify($params = [], $condition = null){
			
			if(empty($params))      die("Está intentando ejecutar la funcion \"modify\" sin parámetros");
			if(!is_array($params))  die("Debe ingresar un arreglo asociativo, cuyas claves deben ser el nombre de los campos de la tabla \"$this->_table\" en la función \"modify\"");
			if(is_null($condition)) die("Debe indicar el id o alguna condición específica en el parámetro \"condition\" de función \"modify\"");

			foreach($params as $key => $value) $set[] = "$key = ?";

			$params = array_values($params);
			$set    = implode(', ',$set);
			$query  = "UPDATE $this->_table SET $set";

			if(is_numeric($condition)){
				
				$query   .= " WHERE $this->_primary_key = ?";
				$params[] = $condition;

			}else{

				$query .= " WHERE $condition";				
			}

			$this->setQuery($query,$params)->runQuery();

			return $this->isRowAffected();

		}

		public function delete($id,$condicion = []){
			if(empty($id)) die("Debe ingresar un id");

			if(!empty($condicion)){
				if(is_array($condicion)){
					
					foreach($condicion as $column => $value){
						$cond []  = $column." = ?";
						$params[] = $value;
					}
					$cond  = implode(" AND ",$cond);
					$query = "DELETE FROM $this->_table WHERE $cond";

				}else{
					$query = "DELETE FROM $this->_table WHERE $cond";
					$params = [];
				}
			}else{
				$query = "DELETE FROM $this->_table WHERE $this->_primary_key = ?";
				$params = [$id];
			}

			$this->setQuery($query,$params)->runQuery();

			return $this->isRowAffected();
		}
	
		private function deleteNull($params = []){

			foreach($params as $key => $value){
				
				if(is_null($value) or empty($value)){

					unset($params[$key]);

				}

			}

			return $params;

		}

		private function isFieldExists($field){

			$arrColumns = $this->getFieldsTable();

			if(in_array($field,$arrColumns)){
				return true;
			}

			return false;

		}
		
		private function getFieldsTable(){	

			$query    = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
			$param    = array($this->_table);
			$response = $this->db->getQuery($query,$param)->runQuery();
			
			if($response->getNumRows() > 0){

				$arrAux = json_decode(json_encode($response->getRows()),true);

				return array_map('current', $arrAux);

			}

			return NULL;
		
		}

		public function getLastInsertId(){

			return $this->_db->getInstance()->lastInsertId();

		}

	}
?>