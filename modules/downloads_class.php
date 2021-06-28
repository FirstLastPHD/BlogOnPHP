<?php

class Downloads extends Module {
	
public function __construct() {
		parent::__construct();
		$this->add("articlesone", null, true);
		$this->add("links", null, true);
		$this->add("more_articles", null, true);
		$this->add("pagination");
	}

	
	public function getTmplFile() {
		return "downloads";
	}
}

?>