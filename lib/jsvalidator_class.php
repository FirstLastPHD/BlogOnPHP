<?php

class JSValidator {
	
	private $message;
	
	public function __construct($message) {
		$this->message = $message;
	}
	
	public function password($f_equal = false, $min_len = true, $t_empty = false) {
		
		if(isset($_POST['save'])) {
			$website_language = $_POST['website_language'];
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
	  
		$cl = $this->getBase();
		if ($min_len) {
			$cl->min_len = ValidatePassword::MIN_LEN;
			$cl->t_min_len = $lang['ERROR_PASSWORD_MIN_LEN'];
		}
		$cl->max_len = ValidatePassword::MAX_LEN;
		$cl->t_max_len = $lang['ERROR_PASSWORD_MAX_LEN'];
		if ($t_empty) $cl->t_empty = $this->message->get($t_empty);
		else $cl->t_empty = $lang['ERROR_PASSWORD_EMPTY'];
		if ($f_equal) {
			$cl->f_equal = $f_equal;
			$cl->t_equal = $lang['ERROR_PASSWORD_CONF'];
		}
		return $cl;
	}
	
	public function name($t_empty = false, $t_max_len = false, $t_type = false) {
		return $this->getBaseData($t_empty, $t_max_len, $t_type, "ValidateName", "name");
	}
	
	public function login($t_empty = false, $t_max_len = false, $t_type = false) {
		return $this->getBaseData($t_empty, $t_max_len, $t_type, "ValidateLogin", "login");
	}
	
	public function email($t_empty = false, $t_max_len = false, $t_type = false) {
		return $this->getBaseData($t_empty, $t_max_len, $t_type, "ValidateEmail", "email");
	}
	
	public function avatar() {
		
		 if(isset($_POST['save'])) {
			$website_language = $_POST['website_language'];
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
	  
		$cl = $this->getBase();
		$cl->t_empty = $lang['ERROR_AVATAR_EMPTY'];
		return $cl;
	}
	
	public function captcha() {
		
			 if(isset($_POST['save'])) {
			$website_language = $_POST['website_language'];
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
	  
		$cl = $this->getBase();
		$cl->t_empty = $lang['ERROR_CAPTCHA_EMPTY'];
		return $cl;
	}
	
	private function getBaseData($t_empty, $t_max_len, $t_type, $class, $type) {
		
		if(isset($_POST['save'])) {
			$website_language = $_POST['website_language'];
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
	  
		$cl = $this->getBase();
		$cl->type = $type;
		$cl->max_len = $class::MAX_LEN;
		
		if ($t_empty) $cl->t_empty = $this->message->get($t_empty);
		else $cl->t_empty = $lang['ERROR_EMAIL_EMPTY'];
		if ($t_max_len) $cl->t_max_len = $this->message->get($t_max_len);
		else $cl->t_max_len = $lang['ERROR_EMAIL_MAX_LEN'];
		if ($t_type) $cl->t_type = $this->message->get($t_type);
		else $cl->t_type = $lang['ERROR_EMAIL_INVALID'];
		return $cl;
	}
	
	private function getBase() {
		$cl = new stdClass();
		$cl->type = "";
		$cl->min_len = "";
		$cl->max_len = "";
		$cl->t_min_len = "";
		$cl->t_max_len = "";
		$cl->t_empty = "";
		$cl->t_type = "";
		$cl->f_equal = "";
		$cl->t_equal = "";
		return $cl;
	}

}

?>