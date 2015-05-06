<?php

namespace Controllers;

use Models\Post;
use Models\User;

class Home {
	function __construct() {
		$this->view = \MVC\View::getInstance();
		$this->users = new User();
		$this->posts = new Post();
	}

	function index() {
		$data['posts'] = $this->posts->getAllPosts();
		$this->view->appendToLayout('header', 'inc.header');
		$this->view->appendToLayout('footer', 'inc.footer');
		$this->view->appendToLayout('posts', 'home.posts');
		$this->view->appendToLayout('side-bar', 'inc.side-bar');
		$this->view->display('home.index', $data, false);
	}
}