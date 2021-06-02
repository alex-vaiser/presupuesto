<?php

class DAOUsuario extends DAO{
	protected $_table;
	protected $_primary_key;

	public function __construct(){
		parent::__construct();

		$this->_table       = "tb_usuarios";
		$this->_primary_key = "id";
	}

	public function isUserValid($user,$password){

		$query  = "SELECT id FROM $this->_table WHERE user = ? AND password = ?";
		$params = [$user,$password];
		$result = $this->setQuery($query,$params)->runQuery()->getResult(0);

		if($result->rowCount > 0){
			return $result->rows->id;
		}

		return false;
	}
	
}
?>