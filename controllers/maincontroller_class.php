<?php

class MainController extends Controller {

	public function actionIndex() {
		
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
	  
		$this->title = $lang['How to create your site'];
		$this->meta_desc = $lang['How to create a website? The answer to this question is on this site. A huge amount of materials on the topics: how to create your site and how to promote the site!'];
		$this->meta_key = $lang['how to create your site, create a site'];
		
		if($language == 'czech'){
		$articles = ArticleDBCZ::getAllShow(Config::COUNT_ARTICLES_ON_PAGE, $this->getOffset(Config::COUNT_ARTICLES_ON_PAGE), true);
		//print_r($articles);
		$pagination = $this->getPagination(ArticleDBCZ::getCount(), Config::COUNT_ARTICLES_ON_PAGE, "/");
		$blog = new Blog();
		$blog->articles = $articles;
		$blog->pagination = $pagination;
		
		}
        if($language == 'english'){
		$articles = ArticleDB::getAllShow(Config::COUNT_ARTICLES_ON_PAGE, $this->getOffset(Config::COUNT_ARTICLES_ON_PAGE), true);
		//print_r($articles);
		$pagination = $this->getPagination(ArticleDB::getCount(), Config::COUNT_ARTICLES_ON_PAGE, "/");
		$blog = new Blog();
		$blog->articles = $articles;
		$blog->pagination = $pagination;
		
		}		
		$this->getOnlineUsersCount();
		$this->geolocation();
		$this->userVisitStatistic();
		$this->render($this->renderData(array("blog" => $blog), "index"));
	}
	public function actionSupport(){
		$support = new Support();
		$this->render($support);
	}
	public function actionCleverArticles(){
		$clever_articles = CleverArticlesDB::getAllShow(Config::COUNT_ARTICLES_ON_PAGE, $this->getOffset(Config::COUNT_ARTICLES_ON_PAGE), true);
		//print_r($articles);
		$pagination = $this->getPagination(CleverArticlesDB::getCount(), Config::COUNT_ARTICLES_ON_PAGE, "/");
		$adv = new CleverArticles();
		$adv->articles = $clever_articles;
		$adv->pagination = $pagination;
		$this->render($adv);
	}
	public function actionGallery() {
		$gallery = new Gallery();
		$this->render($gallery);
	}
	public function actionDownloads() {
		
		$articles = DownloadsDB::getAllShow(1000, $this->getOffset(10), true);
		$pagination = $this->getPagination(DownloadsDB::getCount(), 1000, "/");
		$downloads = new Downloads();
		$downloads->articlesone = $articles;
		$downloads->pagination = $pagination;
		$this->render($downloads);
		
	}
	/**** ---- ACTION SECTION CZ ---- ****/
		public function actionSectioncz() {
		
		$section_db = new SectionDBCZ();
		$section_db->load($this->request->id);
		if (!$section_db->isSaved()) $this->notFound();
		$this->section_id = $section_db->id;
		$this->title = $section_db->title;
		$this->meta_desc = $section_db->meta_desc;
		$this->meta_key = $section_db->meta_key;
		
		$hornav = $this->getHornav();
		$hornav->addData($section_db->title);
		
		$intro = new Intro();
		$intro->hornav = $hornav;
		$intro->obj = $section_db;
		
		$blog = new Blog();
		$articles = ArticleDBCZ::getAllOnPageAndSectionID($this->request->id, Config::COUNT_ARTICLES_ON_PAGE);
		$more_articles = ArticleDBCZ::getAllOnSectionID($this->request->id, false);
		
		$i = 0;
		foreach ($more_articles as $id => $article) {
			$i++;
			unset($more_articles[$id]);
			if ($i == Config::COUNT_ARTICLES_ON_PAGE) break;
		}
		$blog->articles = $articles;
		$blog->more_articles = $more_articles;
		$this->render($intro.$blog);
	}
	/**** ---- END ACTION SECTION CZ ----****/
	/**** ---- ACTION CATEGORY CZ ---- ****/
		public function actionCategorycz() {
		$category_db = new CategoryDBCZ();
		$category_db->load($this->request->id);
		if (!$category_db->isSaved()) $this->notFound();
		$this->section_id = $category_db->section_id;
		$this->title = $category_db->title;
		$this->meta_desc = $category_db->meta_desc;
		$this->meta_key = $category_db->meta_key;
		
		$section_db = new SectionDBCZ();
		$section_db->load($category_db->section_id);
		
		$hornav = $this->getHornav();
		$hornav->addData($section_db->title, $section_db->link);
		$hornav->addData($category_db->title);
		
		$intro = new Intro();
		$intro->hornav = $hornav;
		$intro->obj = $category_db;
		
		$category = new Category();
		
		$articles = ArticleDBCZ::getAllOnCatID($this->request->id, Config::COUNT_ARTICLES_ON_PAGE);
				
		$category->articles = $articles;
		
		$this->render($intro.$category);
	}
	/**** ---- END ACTION CATEGORY CZ ----****/
	/**** ---- ACTION ARTICLE CZ ---- ****/
		public function actionArticlecz() {
		//echo('I am here');
		$article_db = new ArticleDBCZ();
		
		$article_db->load($this->request->id);
		if (!$article_db->isSaved()) $this->notFound();
		$this->title = $article_db->title;
		$this->meta_desc = $article_db->meta_desc;
		$this->meta_key = $article_db->meta_key;
		
		$hornav = $this->getHornav();
		
		if ($article_db->section) {
			$this->section_id = $article_db->section->id;
			$hornav->addData($article_db->section->title, $article_db->section->link);
			$this->url_active  = URL::get("sectioncz", "", array("id" => $article_db->section->id));
		}
		if ($article_db->category) {
			$hornav->addData($article_db->category->title, $article_db->category->link);
			$this->url_active  = URL::get("categorycz", "", array("id" => $article_db->category->id));
		}
		
		$hornav->addData($article_db->title);
		
		$prev_article_db = new ArticleDBCZ();
		$prev_article_db->loadPrevArticle($article_db);
		$next_article_db = new ArticleDBCZ();
		$next_article_db->loadNextArticle($article_db);
		
		$article = new Article();
		$article->hornav = $hornav;
		$article->auth_user = $this->auth_user;
		$article->article = $article_db;
		if ($prev_article_db->isSaved()) $article->prev_article = $prev_article_db;
		if ($next_article_db->isSaved()) $article->next_article = $next_article_db;
		
		$article->link_register = URL::get("register");
		
		$comments = CommentDBCZ::getAllOnArticleID($article_db->id);
		$article->comments = $comments;
		
		$this->render($article);
		
	}
	/**** ---- END ACTION ARTICLE CZ ----****/
	public function actionSection() {
		$section_db = new SectionDB();
		$section_db->load($this->request->id);
		if (!$section_db->isSaved()) $this->notFound();
		$this->section_id = $section_db->id;
		$this->title = $section_db->title;
		$this->meta_desc = $section_db->meta_desc;
		$this->meta_key = $section_db->meta_key;
		
		$hornav = $this->getHornav();
		$hornav->addData($section_db->title);
		
		$intro = new Intro();
		$intro->hornav = $hornav;
		$intro->obj = $section_db;
		
		$blog = new Blog();
		
		$articles = ArticleDB::getAllOnPageAndSectionID($this->request->id, Config::COUNT_ARTICLES_ON_PAGE);
		 //print_r($articles);
		$more_articles = ArticleDB::getAllOnSectionID($this->request->id, false);
		
		$i = 0;
		foreach ($more_articles as $id => $article) {
			$i++;
			unset($more_articles[$id]);
			if ($i == Config::COUNT_ARTICLES_ON_PAGE) break;
		}
		//print_r($articles->url);
		$blog->articles = $articles;
		$blog->more_articles = $more_articles;
		$this->render($intro.$blog);
	}
	
	public function actionCategory() {
		$category_db = new CategoryDB();
		$category_db->load($this->request->id);
		if (!$category_db->isSaved()) $this->notFound();
		$this->section_id = $category_db->section_id;
		$this->title = $category_db->title;
		$this->meta_desc = $category_db->meta_desc;
		$this->meta_key = $category_db->meta_key;
		
		$section_db = new SectionDB();
		$section_db->load($category_db->section_id);
		
		$hornav = $this->getHornav();
		$hornav->addData($section_db->title, $section_db->link);
		$hornav->addData($category_db->title);
		
		$intro = new Intro();
		$intro->hornav = $hornav;
		$intro->obj = $category_db;
		
		$category = new Category();
		
		$articles = ArticleDB::getAllOnCatID($this->request->id, Config::COUNT_ARTICLES_ON_PAGE);
				
		$category->articles = $articles;
		
		$this->render($intro.$category);
	}
	
	public function actionArticle() {
		
		$article_db = new ArticleDB();
		
		$article_db->load($this->request->id);
		if (!$article_db->isSaved()) $this->notFound();
		$this->title = $article_db->title;
		$this->meta_desc = $article_db->meta_desc;
		$this->meta_key = $article_db->meta_key;
		
		$hornav = $this->getHornav();
		
		if ($article_db->section) {
			$this->section_id = $article_db->section->id;
			$hornav->addData($article_db->section->title, $article_db->section->link);
			$this->url_active  = URL::get("section", "", array("id" => $article_db->section->id));
		}
		if ($article_db->category) {
			$hornav->addData($article_db->category->title, $article_db->category->link);
			$this->url_active  = URL::get("category", "", array("id" => $article_db->category->id));
		}
		
		$hornav->addData($article_db->title);
		
		$prev_article_db = new ArticleDB();
		$prev_article_db->loadPrevArticle($article_db);
		$next_article_db = new ArticleDB();
		$next_article_db->loadNextArticle($article_db);
		
		$article = new Article();
		$article->hornav = $hornav;
		$article->auth_user = $this->auth_user;
		$article->article = $article_db;
		if ($prev_article_db->isSaved()) $article->prev_article = $prev_article_db;
		if ($next_article_db->isSaved()) $article->next_article = $next_article_db;
		
		$article->link_register = URL::get("register");
		
		$comments = CommentDB::getAllOnArticleID($article_db->id);
		$article->comments = $comments;
		
		$this->render($article);
		
	}
	
	/**** ---- POLLDB FOR DIFFERENT LEANGUAGES ---- ****/
	public function actionPoll() {
		
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
	    if($language == 'czech'){
		 MenuDB::$table = "menucz";
         PollDB::$table = 'pollscz"';
         PollVoterDB::$table = "poll_voterscz";
		 PollDataDB::$table = "poll_datacz";
		}
		$message_name = $lang['poll'];
		if ($this->request->poll) {
			$poll_voter_db = new PollVoterDB();
			$poll_data = PollDataDB::getAllOnPollID($this->request->id);
			$already_poll = PollVoterDB::isAlreadyPoll(array_keys($poll_data));
			$checks = array(array($already_poll, false, $lang['ERROR_ALREADY_POLL']));
			$this->fp->process($message_name, $poll_voter_db, array("poll_data_id"), $checks, $lang['SUCCESS_POLL']);
			$this->redirect(URL::current());
		}
		$poll_db = new PollDB();
		$poll_db->load($this->request->id);
		if (!$poll_db->isSaved()) $this->notFound();
		$this->title = $lang['Voting results'].": ".$poll_db->title;
		$this->meta_desc = $lang['Voting results'].": ".$poll_db->title.".";
		$this->meta_key = "voting results, ".mb_strtolower($poll_db->title);
		
		$poll_data = PollDataDB::getAllDataOnPollID($poll_db->id);
		
		$hornav = $this->getHornav();
		$hornav->addData($poll_db->title);
		
		$poll_result = new PollResult();
		$poll_result->hornav = $hornav;
		$poll_result->message = $this->fp->getSessionMessage($message_name);
		$poll_result->title = $poll_db->title;
		$poll_result->data = $poll_data;
		
		$this->render($poll_result);
		
	}
	/**** ---- END POLLDB FOR DIFFERENT LEANGUAGES ---- ****/
	
	/**** ---- ACTION POLL CZ ---- ****/
		public function actionPollcz() {
		
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
	  
		$message_name = $lang['poll'];
		if ($this->request->poll) {
			$poll_voter_db = new PollVoterDBCZ();
			$poll_data = PollDataDBCZ::getAllOnPollID($this->request->id);
			$already_poll = PollVoterDBCZ::isAlreadyPoll(array_keys($poll_data));
			$checks = array(array($already_poll, false, "ERROR_ALREADY_POLL"));
			$this->fp->process($message_name, $poll_voter_db, array("poll_data_id"), $checks, "SUCCESS_POLL");
			$this->redirect(URL::current());
		}
		$poll_db = new PollDB();
		$poll_db->load($this->request->id);
		if (!$poll_db->isSaved()) $this->notFound();
		$this->title = $lang['Voting results'].": ".$poll_db->title;
		$this->meta_desc = $lang['Voting results'].": ".$poll_db->title.".";
		$this->meta_key = "voting results, ".mb_strtolower($poll_db->title);
		
		$poll_data = PollDataDBCZ::getAllDataOnPollID($poll_db->id);
		
		$hornav = $this->getHornav();
		$hornav->addData($poll_db->title);
		
		$poll_result = new PollResult();
		$poll_result->hornav = $hornav;
		$poll_result->message = $this->fp->getSessionMessage($message_name);
		$poll_result->title = $poll_db->title;
		$poll_result->data = $poll_data;
		
		$this->render($poll_result);
		
	}
	/**** ---- END ACTION POLL CZ ---- ****/
	public function actionRegister() {
		$message_name = "register";
		if ($this->request->register) {
			$user_old_1 = new UserDB();
			$user_old_1->loadOnEmail($this->request->email);
			$user_old_2 = new UserDB();
			$user_old_2->loadOnLogin($this->request->login);
			$captcha = $this->request->captcha;
			$checks = array(array(Captcha::check($captcha), true, "ERROR_CAPTCHA_CONTENT"));
			$checks[] = array($this->request->password, $this->request->password_conf, "ERROR_PASSWORD_CONF");
			$checks[] = array($user_old_1->isSaved(), false, "ERROR_EMAIL_ALREADY_EXISTS");
			$checks[] = array($user_old_2->isSaved(), false, "ERROR_LOGIN_ALREADY_EXISTS");
			$user = new UserDB();
			$fields = array("name", "login", "email", array("setPassword()", $this->request->password));
			$user = $this->fp->process($message_name, $user, $fields, $checks);
			if ($user instanceof UserDB) {
				$this->mail->send($user->email, array("user" => $user, "link" => URL::get("activate", "", array("login" => $user->login, "key" => $user->activation), false, Config::ADDRESS)), "register");
				$this->redirect(URL::get("sregister"));
			}
		}
		$this->title = "Registration on the site ".Config::SITENAME;
		$this->meta_desc = "Registration on the site ".Config::SITENAME.".";
		$this->meta_key = "registration site ".mb_strtolower(Config::SITENAME).", register site ".mb_strtolower(Config::SITENAME);
		$hornav = $this->getHornav();
		$hornav->addData("Check in");
		
		$form = new Form();
		$form->hornav = $hornav;
		$form->header = "Check in";
		$form->name = "register";
		$form->action = URL::current();
		$form->message = $this->fp->getSessionMessage($message_name);
		$form->text("name", "Name and / or surname:", $this->request->name);
		$form->text("login", "Login:", $this->request->login);
		$form->text("email", "E-mail:", $this->request->email);
		$form->password("password", "Password:");
		$form->password("password_conf", "Confirm the password:");
		$form->captcha("captcha", "Enter the code from the image:");
		$form->submit("Check in");
		
		$form->addJSV("name", $this->jsv->name());
		$form->addJSV("login", $this->jsv->login());
		$form->addJSV("email", $this->jsv->email());
		$form->addJSV("password", $this->jsv->password("password_conf"));
		$form->addJSV("captcha", $this->jsv->captcha());
		
		$this->render($form);
		
	}
	
	public function actionSRegister() {
		$this->title = "Registration on the site ".Config::SITENAME;
		$this->meta_desc = "Registration on the site ".Config::SITENAME.".";
		$this->meta_key = "registration site ".mb_strtolower(Config::SITENAME).", register site ".mb_strtolower(Config::SITENAME);
	
		$hornav = $this->getHornav();
		$hornav->addData("Check in");
		
		$pm = new PageMessage();
		$pm->hornav = $hornav;
		$pm->header = "Check in";
		$pm->text = "The account has been created. A letter with instructions for activation was sent to your e-mail address. If the letter does not reach, then contact the administration.";
		$this->render($pm);
	}
	
	
	public function actionActivate() {
		
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
	  
		$user_db = new UserDB();
		$user_db->loadOnLogin($this->request->login);
		$hornav = $this->getHornav();
		if ($user_db->isSaved() && ($user_db->activation == "")) {
			$this->title = $lang['Your account has already been activated'];
			$this->meta_desc = $lang['You can log in to your account using your login and password'].".";
			$this->meta_key = "activation, successful activation, successful activation";
			$hornav->addData($lang['Activation']);
		}
		elseif ($user_db->activation != $this->request->key) {
			$this->title = $lang['Activation error'];
			$this->meta_desc = $lang['Invalid activation code! If the error persists, contact the administration'].".";
			$this->meta_key = "activation, activation error, activation error registration";
			$hornav->addData($lang['Activation error']);
		}
		else {
			$user_db->activation = "";
			try {
				$user_db->save();
			} catch (Exception $e) {print_r($e->getMessage());}
			$this->title = $lang['Your account has been successfully activated'];
			$this->meta_desc = $lang['Now you can log in to your account using your login and password'].".";
			$this->meta_key = "activation, successful activation, successful activation";
			$hornav->addData($lang['Activation']);
		}
		
		$pm = new PageMessage();
		$pm->hornav = $hornav;
		$pm->header = $this->title;
		$pm->text = $this->meta_desc;
		$this->render($pm);
	}
	
	public function actionLogout() {
		UserDB::logout();
		$this->redirect($_SERVER["HTTP_REFERER"]);
	}
	
	public function actionReset() {
		
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
	  
		$message_name = $lang['reset'];
		$this->title = $lang['Password recovery'];
		$this->meta_desc = $lang['Recovering a user password'].".";
		$this->meta_key = "password recovery, user password recovery";
		$hornav = $this->getHornav();
		$hornav->addData($lang['Password recovery']);
		if ($this->request->reset) {
			$user_db = new UserDB();
			$user_db->loadOnEmail($this->request->email);
			if ($user_db->isSaved()) $this->mail->send($user_db->email, array("user" => $user_db, "link" => URL::get("reset", "", array("email" => $user_db->email, "key" => $user_db->getSecretKey()), false, Config::ADDRESS)), "reset");
			$pm = new PageMessage();
			$pm->hornav = $hornav;
			$pm->header = $lang['Password recovery'];
			$pm->text = $lang['Instructions for password recovery sent to the specified e-mail address'].".";
			$this->render($pm);
		}
		elseif ($this->request->key) {
			$user_db = new UserDB();
			$user_db->loadOnEmail($this->request->email);
			if ($user_db->isSaved() && ($this->request->key === $user_db->getSecretKey())) {
				if ($this->request->reset_password) {
					$checks = array(array($this->request->password_reset, $this->request->password_reset_conf, $lang['ERROR_PASSWORD_CONF']));
					$user_db = $this->fp->process($message_name, $user_db, array(array("setPassword()", $this->request->password_reset)), $checks);
					if ($user_db instanceof UserDB) {
						$user_db->login();
						$this->redirect(URL::get("sreset"));
					}
				}
				$form = new Form();
				$form->hornav = $hornav;
				$form->header = $lang['Password recovery'];
				$form->name = $lang['reset_password'];
				$form->action = URL::current();
				$from->message = $this->fp->getSessionMessage($message_name);
				$form->password("password_reset", $lang['New password'].":");
				$form->password("password_reset_conf", $lang['Confirm password'].":");
				$form->submit("Next");
				
				$form->addJSV("password_reset", $this->jsv->password("password_reset_conf"));
				$this->render($form);
			}
			else {
				$pm = new PageMessage();
				$pm->hornav = $hornav;
				$pm->header = $lang['Invalid key'];
				$pm->text = $lang['Try again, if the error repeats, then contact the administration'].".";
				$this->render($pm);
			}
		}
		else {
			$form = $this->getFormEmail($lang['Password recovery'], "reset", $message_name);
			$form->hornav = $hornav;
			$this->render($form);
		}
	}
	
	public function actionSReset() {
		
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
	  
		$this->title = $lang['Password recovery'];
		$this->meta_desc = $lang['Password recovery completed successfully'].".";
		$this->meta_key = "password recovery, user password recovery, user password recovery completed";
		
		$hornav = $this->getHornav();
		$hornav->addData($lang['Password recovery']);
		
		$pm = new PageMessage();
		$pm->hornav = $hornav;
		$pm->header = $lang['Password changed successfully']."!";
		$pm->text = $lang['Now you can enter the site if you are not automatically authorized'].".";
		
		$this->render($pm);
	}
	
	public function actionRemind() {
		
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
	  
		$this->title = $lang['Login recovery'];
		$this->meta_desc = $lang['Restore login'].".";
		$this->meta_key = $lang['restore the login, restore the login'];
		$hornav = $this->getHornav();
		$hornav->addData($lang['Login recovery']);
		if ($this->request->remind) {
			$user_db = new UserDB();
			$user_db->loadOnEmail($this->request->email);
			if ($user_db->isSaved()) $this->mail->send($user_db->email, array("user" => $user_db), "remind");
			$pm = new PageMessage();
			$pm->hornav = $hornav;
			$pm->header = $lang['Login recovery'];
			$pm->text = $lang['A letter with your login has been sent to the specified e-mail address'].".";
			$this->render($pm);
		}
		else {
			$form = $this->getFormEmail($lang['Login recovery'], "remind", "remind");
			$form->hornav = $hornav;
			$this->render($form);
		}
	}
	
	
	public function actionSearch() {
		
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
	  
		$hornav = $this->getHornav();
		$hornav->addData($lang['Search']);
		$this->title = $lang['Search'].": ".$this->request->query;
		$this->meta_desc = $lang['Search']." ".$this->request->query.".";
		$this->meta_key = "search, search ".$this->request->query;
		$articles = ArticleDB::search($this->request->query);
		$sr = new SearchResult();
		if (mb_strlen($this->request->query) < Config::MIN_SEARCH_LEN) $sr->error_len = true;
		$sr->hornav = $hornav;
		$sr->field = $lang['full'];
		$sr->query = $this->request->query;
		$sr->data = $articles;
		
		$this->render($sr);
	}
	
	private function getFormEmail($header, $name, $message_name) {
			
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
	  
		$form = new Form();
		$form->header = $header;
		$form->name = $name;
		$form->action = URL::current();
		$form->message = $this->fp->getSessionMessage($message_name);
		$form->text("email", $lang['Enter the e-mail provided during registration'].":", $this->request->email);
		$form->submit($lang['Next']);
		$form->addJSV("email", $this->jsv->email());
		return $form;
	}
	
}

?>