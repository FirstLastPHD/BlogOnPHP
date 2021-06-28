<?php

abstract class ObjectDB extends AbstractObjectDB {
	
	private static $months = array("Jen", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Now", "Dec");
	
	public function __construct($table){
		parent::__construct($table, Config::FORMAT_DATE);
	}
	
	protected static function getMonth($date=false){
		if($date) $date = strtotime($date);
		else $date = time();
		return self::$months[date("n", $date) -1];
	}
	
	public function preEdit($field, $value) {
		return true;
	}
	
	public function postEdit($field, $value) {
		return true;
	}
	
	public function accessEdit($auth_user, $field) {
		return false;
	}
	
	public function accessDelete($auth_user) {
		return false;
	}
		
}

?>