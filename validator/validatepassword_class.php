<?php

class ValidatePassword extends Validator {
	
	const MIN_LEN = 6;
	const MAX_LEN = 100;
	//const CODE_EMPTY = "ERROR_PASSWORD_EMPTY";
	//const CODE_CONTENT = "ERROR_PASSWORD_CONTENT";
	//const CODE_MIN_LEN = "ERROR_PASSWORD_MIN_LEN";
	//const CODE_MAX_LEN = "ERROR_PASSWORD_MAX_LEN";
	
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
		if (mb_strlen($data) == 0) $this->setError($lang['ERROR_PASSWORD_EMPTY']);
		else {
			if (mb_strlen($data) < self::MIN_LEN) $this->setError($lang['ERROR_PASSWORD_MIN_LEN']);
			elseif (mb_strlen($data) > self::MAX_LEN) $this->setError($lang['ERROR_PASSWORD_MAX_LEN']);
			elseif (!preg_match("/^[a-z0-9_]+$/i", $data)) $this->setError($lang['ERROR_PASSWORD_CONTENT']);
		}
	}
	
}

?>