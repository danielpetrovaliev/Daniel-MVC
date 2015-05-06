<?php

namespace Controllers;

use Models\Post;
use Models\User;

class Home extends BaseController {
	function __construct() {
        parent::__construct();
		//$this->users = new User();
		$this->posts = new Post();
	}

	function index() {
		$data['posts'] = $this->posts->getAllPosts();
        $this->view->appendToLayout('posts', 'post.posts_template');
		$this->view->display('post.posts', $data, false);
	}
}