<?php

class SportNewsDB extends ObjectDB {
	
	protected static $table = "polls";
	
	public function __construct() {
		parent::__construct(self::$table);
		$this->add("title", "ValidateTitle");
		$this->add("state", "ValidateBoolean", null, 0);
	}
	
	public static function loadRandom() {
		
		$row = "";
		//print_r($row);
		return $row;
	}
	
}

?>