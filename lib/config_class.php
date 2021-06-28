<?php

abstract class Config{
	
	const SITENAME = "JaroslavKing.eu";
	const SECRET = "DGLJDG5";
	const ADDRESS = "http://myblog.cz/";
	const ADM_NAME = "Jaroslav King";
	const ADM_MAIL = "admin@jaroslav-king.eu";
	
	const API_KEY = "DKEL39DL";
	const DB_HOST = "localhost";
	const DB_USER = "root3";
	const DB_PASSWORD = "slavikFirst1111";
	const DB_NAME = "jaroslav-king";
	const DB_PREFIX = "xyz_";
	const DB_SYM_QUERY = "?";
	
	const DIR_IMG = "/images/";
	const DIR_IMG_ARTICLES = "/images/articles/";
	const DIR_AVATAR = "/images/avatars/";
	const DIR_TMPL = "C:\OSPanel\domains\myblog.cz/tmpl/";
	const DIR_EMAILS = "C:\OSPanel\domains\myblog.cz/tmpl/emails/";
	
	const LAYOUT = "main";
	const FILE_MESSAGES = "C:\OSPanel\domains\myblog.cz/text/messages.ini";
	const FORMAT_DATE = "%d.%m.%Y %H:%M:%S";
	const COUNT_ARTICLES_ON_PAGE = 3;
	const COUNT_SHOW_PAGES = 10;
	const MIN_SEARCH_LEN = 3;
	const LEN_SEARCH_RES = 255;
	const SEF_SUFFIX = ".html";
	const DEFAULT_AVATAR = "default.png";
	const MAX_SIZE_AVATAR = 51200;
	
}

?>