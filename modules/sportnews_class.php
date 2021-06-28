<?php

class SportNews extends Module{
	
	public function __construct(){
		parent::__construct();
		$this->add("title");
		$this->add("action");
		//$this->add("data", null, true);
	}
	
	public function getTmplFile() {
		return "sportnews";
	}
		
}



?>