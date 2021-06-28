<?php

class Message {
	
	private $data;
	
	public function __construct($file) {
		//$this->data = parse_ini_file(__DIR__ . '/../text/messages.ini');
		$this->data = parse_ini_file($file);
	}
	
	public function get($name) {
		return $this->data[$name];
	}
	
}

?>