<?php

class ValidateText extends Validator {
	
	const MAX_LEN = 50000;
	//const CODE_EMPTY = "ERROR_TEXT_EMPTY";
	//const CODE_MAX_LEN = "ERROR_TEXT_MAX_LEN";
	
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
		if (mb_strlen($data) == 0) $this->setError($lang['ERROR_TEXT_EMPTY']);
		elseif (mb_strlen($data) > self::MAX_LEN) $this->setError($lang['ERROR_TEXT_MAX_LEN']);
	}
	
}

?>