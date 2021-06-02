<?php

class Controller{

	protected $load;
	protected $request;

	public function __construct(){
		
		$this->load    = new Loader();
		$this->request = new Request();
		
	}
}
?>