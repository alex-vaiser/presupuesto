<?php
	class Menu extends Controller{
		
		protected $_daoMenu;

		public function __construct(){
			parent::__construct();

			$this->_daoMenu = $this->load->dao("DAOMenu");
		}

		public function getList(){
			return $this->_daoMenu->getList();
		}
	}
?>