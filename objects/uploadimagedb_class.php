<?php
class UploadImageDB extends ObjectDB {

    protected static $table = "uploads";
	//$mysqli = new mysqli('localhost', 'root','','jaroslav_king_DB');
	public function __construct() {
		parent::__construct(self::$table);
		$this->add("id", "ValidateID");
		$this->add("describe", "ValidateTitle");
		$this->add("picture_path", "ValidateIMG");
		//$this->add("intro", "ValidateText");
		//$this->add("full", "ValidateText");
		//$this->add("section_id", "ValidateID");
		//$this->add("cat_id", "ValidateID");
		//$this->add("date", "ValidateDate", self::TYPE_TIMESTAMP, $this->getDate());
		//$this->add("meta_desc", "ValidateMD");
		//$this->add("meta_key", "ValidateMK");
		//print_r($this);
	}
	
	public static function getAllOnDownloads() {
		//$select = new Select("describe");
		//$select = new Select("describe");
		//$select->order("date", false);
		$select = new Select(self::$db);
		$select->from(self::$table,"*");
		//$select->from(self::$table, "*");
			//->where("`id` = ".self::$db->getSQ(), array($id));
		$downloads = ObjectDB::buildMultiple(__CLASS__, self::$db->select($select));
		//$downloads ='hihihihihihuihih';
		//$downloads = ObjectDB::addSubObject($downloads, "id");
		//print_r($downloads);
		return $downloads;
	}
	
	protected function postInit() {
		$this->link = URL::get("Downloads", "", array("id" => $this->id));
		return true;
	}
	public function loadOnDescribe($describe) {
		return $this->loadOnField("describe", $describe);
	}
	
	public function loadOnImage($image_path) {
		return $this->loadOnField("picture_path", $image_path);
	}
	
	
	
}



?>