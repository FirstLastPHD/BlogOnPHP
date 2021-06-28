<?php

class ValidateMD extends Validator {
	
	const MAX_LEN = 255;
	//const CODE_EMPTY = "ERROR_MD_EMPTY";
	//const CODE_MAX_LEN = "ERROR_MD_MAX_LEN";
	
	protected function validate() {
		
		 if(isset($_POST['save'])) {
			$website_language = $_POST['website_language'];
		}
		if(isset($website_language)){
		$_SESSION['language'] = $website_language;
		}
		
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
	  
		$data = $this->data;
		if (mb_strlen($data) == 0) $this->setError($lang['ERROR_MD_EMPTY']);
		if (mb_strlen($data) > self::MAX_LEN) $this->setError($lang['ERROR_MD_MAX_LEN']);
	}
	
}

?>