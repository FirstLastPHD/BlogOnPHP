<?php

abstract class Controller extends AbstractController {
	
	protected $title;
	protected $meta_desc;
	protected $meta_key;
	protected $mail = null;
	protected $url_active;
	protected $section_id = 0;
	
	public function __construct() {
		parent::__construct(new View(Config::DIR_TMPL), new Message(Config::FILE_MESSAGES));
		$this->mail = new Mail();
		$this->url_active = URL::deleteGET(URL::current(), "page");
	}
	
	public function action404() {
		 ob_start();
		
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
	   //if (headers_sent()) {
		   //die("Redirect failed. Please click on this link: <a href=http://www.google.com>");
	   //}
	   //else{
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
	  // }
		$this->title = $lang['Page not found - 404'];
		$this->meta_desc = $lang['The requested page does not exist'];
		$this->meta_key = "page not found, page does not exist, 404";
		
		$pm = new PageMessage();
		$pm->header = $lang['Page not found'];
		$pm->text = $lang['Unfortunately, the requested page does not exist. Verify that the address is correct'].".";
		$this->render($pm);
		ob_end_flush();
		 
	}
	
	protected function accessDenied() {
		
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
	  
		$this->title = $lang['Access closed!'];
		$this->meta_desc = $lang['Access to this page is closed'].".";
		$this->meta_key = "access is closed, access is denied, access is denied page 403";
		
		$pm = new PageMessage();
		$pm->header = $lang['Access closed!'];
		$pm->text = $lang['You do not have permission to access this page'].".";
		$this->render($pm);
	}
	
	final protected function render($str) {
		
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
		//print_r($language);
		
		
		$params = array();
		$params["header"] = $this->getHeader();
		$params["auth"] = $this->getAuth();
		$params["top"] = $this->getTop();
		$params["slider"] = $this->getSlider();
		
		if($language == 'english'){
		$params["left"] = $this->getLeft();
		}
		if($language == 'czech'){
		   $params["left"] = $this->getLeftcz();
		}
		//if($language == 'denmark'){
		//$params["left"] = $this->getLeft('menucz', 'polls','poll_voters','poll_data', 'sef');
		//}
		$params["right"] = $this->getRight();
		$params["center"] = $str;
		$params["link_search"] = URL::get("search");
		//$params["link_gallery"] = URL::get("Gallery");
		$this->view->render(Config::LAYOUT, $params);
	}
	
	protected function getHeader() {
		$header = new Header();
		$header->title = $this->title;
		$header->meta("Content-Type", "text/html; charset=utf-8", true);
		$header->meta("description", $this->meta_desc, false);
		$header->meta("keywords", $this->meta_key, false);
		$header->meta("viewport", "width=device-width", false);
		$header->favicon = "/favicon.ico";
		$header->css = array("/styles/main.css", "/styles/prettify.css", "/styles/calendar.css", "/styles/slick.css");
		$header->js = array("/js/jquery-3.2.1.min.js", "/js/functions.js", "/js/validator.js", "/js/prettify.js","/js/SiteClock.js",
		"/js/google.js");
		return $header;
	}
	
	protected function getAuth() {
		if ($this->auth_user) return "";
		$auth = new Auth();
		$auth->message = $this->fp->getSessionMessage("auth");
		$auth->action = URL::current("", true);
		$auth->link_register = URL::get("register");
		$auth->link_reset = URL::get("reset");
		$auth->link_remind = URL::get("remind");
		return $auth;
	}
	
	protected function getTop() {
		$items = MenuDB::getTopMenu();
		$topmenu = new TopMenu();
		$topmenu->uri = $this->url_active;
		$topmenu->items = $items;
		return $topmenu;
	}
	
	protected function getSlider() {
		$course = new CourseDB();
		$course->loadOnSectionID($this->section_id, PAY_COURSE);
		$slider = new Slider();
		$slider->course = $course;
		return $slider;
	}
	
	/**** ---- Left Panel CZ ---- ****/
	protected function getLeftcz() {
		
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
	  
		
		$items = MenuDBCZ::getMainMenu();
		$mainmenu = new MainMenu();
		$mainmenu->uri = $this->url_active;
		$mainmenu->items = $items;
		if ($this->auth_user) {
			$user_panel = new UserPanel();
			$user_panel->user = $this->auth_user;
			$user_panel->uri = $this->url_active;
			$user_panel->addItem($lang['Edit Profile'], URL::get("editprofile", "user"));
			$user_panel->addItem($lang['Exit'], URL::get("logout"));
		}
			else $user_panel = "";
	    
		$poll_db = new PollDBCZ();
		$poll_db->loadRandom();
		if ($poll_db->isSaved()) {
			$poll = new Poll();
			$poll->action = URL::get("pollcz", "", array("id" => $poll_db->id));
			$poll->title = $poll_db->title;
			$poll->data = PollDataDBCZ::getAllOnPollID($poll_db->id);
		}
		else $poll = "";
		//print_r($mainmenu);
		return $user_panel.$mainmenu.$poll;
	}
   /**** ---- END Left Panel CZ ---- ****/
	/**** ---- Left Panel ---- ****/
	protected function getLeft() {
		
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
		
		$items = MenuDB::getMainMenu();
		$mainmenu = new MainMenu();
		$mainmenu->uri = $this->url_active;
		$mainmenu->items = $items;
		if ($this->auth_user) {
			$user_panel = new UserPanel();
			$user_panel->user = $this->auth_user;
			$user_panel->uri = $this->url_active;
			$user_panel->addItem($lang['Edit Profile'], URL::get("editprofile", "user"));
			$user_panel->addItem($lang['Exit'], URL::get("logout"));
		}
			else $user_panel = "";
	    
		$poll_db = new PollDB();
		$poll_db->loadRandom();
		if ($poll_db->isSaved()) {
			$poll = new Poll();
			$poll->action = URL::get("poll", "", array("id" => $poll_db->id));
			$poll->title = $poll_db->title;
			$poll->data = PollDataDB::getAllOnPollID($poll_db->id);
		}
		else $poll = "";
		//print_r($mainmenu);
		return $user_panel.$mainmenu.$poll;
	}
	
	/**** ---- End Left Panel ---- ****/
	
	protected function getRight() {
		$course_db_1 = new CourseDB();
		$course_db_1->loadOnSectionID($this->section_id, FREE_COURSE);
		$course_db_2 = new CourseDB();
		$course_db_2->loadOnSectionID($this->section_id, ONLINE_COURSE);
		$courses = array($course_db_1, $course_db_2);
		
		$course = new Course();
		$course->courses = $courses;
		$course->auth_user = $this->auth_user;
		
		$quote_db = new QuoteDB();
		$quote_db->loadRandom();
		
		$quote = new Quote();
		$quote->quote = $quote_db;
		
		$sport =new	SportNews();
	    $sport->title =SportNewsDB::loadRandom();
		//$sport->action = URL::get("sport", "", array(1));
		//Money Advirstment
		$googleAdv = new Googleadv();
		$responder = new Responder();
		
		//$clever_articles = CleverArticlesDB::getAllShow(1, $this->getOffset(1), true);
		//print_r($clever_articles);
		//$pagination = $this->getSliderPagination(CleverArticlesDB::getCount(), 1, "/");
		//print_r($pagination);
		//$adv = new CleverArticles();
		//$adv->articles = $clever_articles;
		//$adv->pagination = $pagination;
		//print_r($adv->articles);
		//$this->render($this->renderData(array("blog" => $blog), "index"));
		//$slider_adv = new Advirstment();
	    
		return $sport.$responder.$quote.$googleAdv;
		
	}
	
	protected function getHornav() {
		$hornav = new Hornav();
		$hornav->addData("Main", URL::get(""));
		return $hornav;
	}
	
	final protected function getOffset($count_on_page) {
		return $count_on_page * ($this->getPage() - 1);
	}
	
	final protected function getPage() {
		$page = ($this->request->page)? $this->request->page: 1;
		if ($page < 1) $this->notFound();
		return $page;
	}
	
		final protected function getSliderPagination($count_elements, $count_on_page, $url = false) {
		$count_pages = ceil($count_elements / $count_on_page);
		$active = $this->getPage();
		if (($active > $count_pages) && ($active > 1)) $this->notFound();
		$pagination = new SliderPagination();
		if (!$url) $url = URL::deletePage(URL::current());
		//print_r($url);
		$pagination->url = $url;
		$pagination->url_page = URL::addTemplatePage($url);
		//print_r($pagination->url_page);
		$pagination->count_elements = $count_elements;
		$pagination->count_on_page = $count_on_page;
		$pagination->count_show_pages = Config::COUNT_SHOW_PAGES;
		$pagination->active = $active;
		//print_r($active);
		return $pagination;
		}
	
	final protected function getPagination($count_elements, $count_on_page, $url = false) {
		$count_pages = ceil($count_elements / $count_on_page);
		$active = $this->getPage();
		if (($active > $count_pages) && ($active > 1)) $this->notFound();
		$pagination = new Pagination();
		if (!$url) $url = URL::deletePage(URL::current());
		//print_r($url);
		$pagination->url = $url;
		$pagination->url_page = URL::addTemplatePage($url);
		//print_r($pagination->url_page);
		$pagination->count_elements = $count_elements;
		$pagination->count_on_page = $count_on_page;
		$pagination->count_show_pages = Config::COUNT_SHOW_PAGES;
		$pagination->active = $active;
		//print_r($active);
		return $pagination;
	}
	
	protected function authUser() {
		$login = "";
		$password = "";
		$redirect = false;
		if ($this->request->auth) {
			$login = $this->request->login;
			$password = $this->request->password;
			$redirect = true;
		}
		$user = $this->fp->auth("auth", "UserDB", "authUser", $login, $password);
		if ($user instanceof UserDB) {
			if ($redirect) $this->redirect(URL::current());
			return $user;
		}
		return null;
	}
	
	protected function geolocation(){
		
		$file = 'ip_geolocation.txt';

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;

        $result = file_get_contents("http://ipgeobase.ru:7020/geo?ip=".$ip);
        $xml = new SimpleXMLElement($result);
        $gelolocation_array = array(
        1=>"Информация об IP ".$xml->ip->attributes[0]."<br>",
        2=>"Сеть: ".$xml->ip->inetnum."<br>",
        3=>"Страна: ".$xml->ip->country."<br>",
        4=>"Город: ".$xml->ip->city."<br>",
        5=>"Область: ".$xml->ip->region."<br>",
        6=>"Округ: ".$xml->ip->district."<br>",
        7=>"Широта: ".$xml->ip->lat."<br>",
        8=>"Долгота: ".$xml->ip->lng."<br>");
       
        $f = fopen($file, 'a');
        fwrite($f,"/******************************/".PHP_EOL);
        fwrite($f,$ip.PHP_EOL);
        foreach ($gelolocation_array as $i => $value) {
        fwrite($f,$gelolocation_array[$i].PHP_EOL);
         }
        fwrite($f,"/******************************/".PHP_EOL);
        fclose($f);
	}

	
		protected function getOnlineUsersCount(){
			$status = session_status();
            if($status == PHP_SESSION_NONE){
            //There is no active session
             session_start();
            }else
            if($status == PHP_SESSION_DISABLED){
            //Sessions are not available
            }else
            if($status == PHP_SESSION_ACTIVE){
            //Destroy current and start new one
            session_destroy();
            session_start();
          }
        $base = "base_sessions.dat"; //файл, в котором храним идентификаторы и время
        $LastTime = time() - 300; //через какое время сессии удаляются (время в секундах)
        touch($base);
        $file = file($base);
        $id = session_id(); //выделяем уникальный идентификатор сессии
        if ($id!='') {
        $ResFile = array();
        foreach($file as $line) {
        list($sid, $utime) = explode('|', $line);
        if ($utime > $LastTime) {
        $ResFile[$sid] = trim($sid).'|'.trim($utime).PHP_EOL;
         }
       }
       $ResFile[$id] = trim($id).'|'.time().PHP_EOL;
       file_put_contents($base, $ResFile, LOCK_EX);
       $file=$ResFile;
      }

	}

        
		protected function userVisitStatistic(){
			$visitordb =  new VisitorsDB();
			
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = @$_SERVER['REMOTE_ADDR'];
            if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
            elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
            else $ip = $remote;
			if(isset($_COOKIE["userhash"])){
			$userhash = $_COOKIE["userhash"]; // Узнаём, что за пользователь
            if (!$userhash) {
            /* Если это новый пользователь, то добавляем ему cookie, уникальные для него */
            $userhash = uniqid();
            setcookie("userhash", $userhash, 0x6FFFFFFF);
           }
          $ip = ip2long($ip); // Преобразуем IP в число
          //print_r($_SERVER["REMOTE_ADDR"]);
          $uri = $_SERVER["REQUEST_URI"]; // Узнаём uri
          $ref = $_SERVER["HTTP_REFERER"]; // Узнаём, откуда пришёл
          $date = time(); // Берём текущее время
		  $insert_array = array(
		  1=>$userhash,
		  2=>$ip,
		  3=>$uri,
		  4=>$ref,
		  5=>$date
		  );
		  //print_r($insert_array);
		  //$visitordb->insertData($insert_array);
          $mysqli = new mysqli(Config::DB_HOST,Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME); // Соединяемся с базой
          $mysqli->query("INSERT INTO `xyz_visitors` (`userhash`, `ip`, `uri`, `ref`, `date`) VALUES ('$userhash', '$ip', '$uri', '$ref', '$date')"); // Добавляем запись
          $mysqli->close(); // Закрываем соединение
			}
		}

	
}

?>