<?php

class VisitorsDB extends ObjectDB {
	
	protected static $table = "visitors";
	
	public function __construct() {
		parent::__construct(self::$table);
		$this->add("userhash", "");
		$this->add("ip", "");
		$this->add("uri", "");
		$this->add("ref", "");
		$this->add("date", "");
	}
	
	public function insertData($row) {
		//print_r($this->table_name);
		$insert = $this->insert($this->table_name, $row);
		//print_r($insert);
		return $insert;
	}
	
	public function insert($table_name, $row) {
		if (count($row) == 0) return false;
		$table_name = $this->getTableName($table_name);
		$fields = "(";
		$values = "VALUES (";
		$params = array();
		print_r($this);
		foreach ($row as $key => $value) {
			$fields .= "`$key`,";
			$values .= $value;
			$params[] = $value;
		}
		$fields = substr($fields, 0, -1);
		$values = substr($values, 0, -1);
		$fields .= ")";
		$values .= ")";
		$query = "INSERT INTO `$table_name` $fields $values";
		return $query;
	}
	
	public function getTableName($table_name) {
		return $this->prefix.$table_name;
	}
	
	private function query($query, $params = false) {
		$success = $this->mysqli->query($this->getQuery($query, $params));
		if (!$success) return false;
		if ($this->mysqli->insert_id === 0) return true;
		return $this->mysqli->insert_id;
	}
	
	
}

?>