<?php
	
class File {
	
		if(isset($website_language)){
		$_SESSION['language'] = $website_language;
		}
		
		//$_SESSION['language'] = $website_language;
		//$language = $_SESSION['language'];
       if(!isset($_SESSION['language'])) {
	   $language = 'english';
        } else {
	   $language = $_SESSION['language'];
       }
      if(defined('IS_AJAX')) {
	   $path = '../languages/'.strtolower($language).'/language.php';
      } else {
	     $path = 'languages/'.strtolower($language).'/language.php';
       }
      require($path);
	
	public static function uploadIMG($file, $max_size, $dir, $root = false, $source_name = false) {
		$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
		foreach ($blacklist as $item)
			if (preg_match("/$item\$/i", $file["name"])) throw new Exception($lang['ERROR_AVATAR_TYPE']);
		$type = $file["type"];
		$size = $file["size"];
		if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/png")) throw new Exception($lang['ERROR_AVATAR_TYPE']);
		if ($size > $max_size) throw new Exception($lang['ERROR_AVATAR_SIZE']);
		if ($source_name) $avatar_name = $file["name"];
		else $avatar_name = self::getName().".".substr($type, strlen("image/"));
		$upload_file = $dir.$avatar_name;
		if (!$root) $upload_file = $_SERVER["DOCUMENT_ROOT"].$upload_file;
		if (!move_uploaded_file($file["tmp_name"], $upload_file)) throw new Exception($lang['UNKNOWN_ERROR']);
		return $avatar_name;
	}
	
	public static function getName() {
		return uniqid();
	}
	
	public static function delete($file, $root = false) {
		if (!$root) $file = $_SERVER["DOCUMENT_ROOT"].$file;
		if (file_exists($file)) unlink($file);
	}
	
	public static function isExists($file, $root = false) {
		if (!$root) $file = $_SERVER["DOCUMENT_ROOT"].$file;
		return file_exists($file);
	}
}

?>