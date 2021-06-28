<?php
ini_set('display_errors', 2);
class View {
	private $dir_tmpl;
	public function __construct($dir_tmpl) {
		$this->dir_tmpl = $dir_tmpl;
	}
	
	public function secureField($value) {
		return htmlspecialchars(strip_tags($value));
	}

	
	public function render($file, $params, $return = false) {
		
		 if(isset($_POST['save'])) {
			$website_language = $this->secureField($_POST['website_language']);
			//print_r($_POST['website_language']);
		}
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
		
		$template = $this->dir_tmpl.$file.".tpl";
		extract($params);
		ob_start();
		include($template);
		if ($return) return ob_get_clean();
		else echo ob_get_clean();
	}
}

?>