<?php

class CleverArticles extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("articles", null, true);
		$this->add("more_articles", null, true);
		$this->add("pagination");
	}
	
	public function preRender() {
		foreach ($this->articles as $article) {
			$article->count_comments_text = $this->numberOf($article->count_comments, array("comments", "comments", "comments"));
		}
		//print_r($this);
	}
	
	public function getTmplFile() {
		return "cleverArticles";
	}
	
}

?>