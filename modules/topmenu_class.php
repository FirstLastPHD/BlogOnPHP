<?php

class TopMenu extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("uri");
		$this->add("items", null, true);
	   
	}
	
	public function preRender() {
		
		$this->add("active", null, true);
		$active = array();
		foreach ($this->items as $item) {
			if ($item->link == $this->uri) {
				$active[] = $item->id;
			}
		}
		$this->active = $active;
	}
	public function getTmplFile() {
		
		
		return "topmenu";
	}

	
}

?>