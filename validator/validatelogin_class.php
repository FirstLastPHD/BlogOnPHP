<?php

class ValidateLogin extends Validator {
	
	const MAX_LEN = 100;
	//const CODE_EMPTY = "ERROR_LOGIN_EMPTY";
	//const CODE_INVALID = "ERROR_LOGIN_INVALID";
	//const CODE_MAX_LEN = "ERROR_LOGIN_MAX_LEN";
	
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
		if (mb_strlen($data) == 0) $this->setError($lang['ERROR_LOGIN_EMPTY']);
		else {
			if (mb_strlen($data) > self::MAX_LEN) $this->setError($lang['ERROR_LOGIN_MAX_LEN']);
			elseif ($this->isContainQuotes($data)) $this->setError($lang['ERROR_LOGIN_INVALID']);
		}
	}
	
}

?>