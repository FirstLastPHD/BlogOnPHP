<?php
class System{
	
		public function secureField($value) {
		return htmlspecialchars(strip_tags($value));
	}
	
	
}

// Multi-Language
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



?>