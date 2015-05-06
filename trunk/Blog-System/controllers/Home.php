<?php

namespace Controllers;

use Models\Post;
use Models\Tag;
use Models\User;

class Home extends BaseController {
    /**
     * @var Post Model
     */
    private $posts;
    /**
     * @var Tag Model
     */
    private  $tags;

	function __construct() {
        parent::__construct();
		//$this->users = new User();
		$this->posts = new Post();
        $this->tags = new Tag();

        // Side bar data
        $this->data['sorted_posts'] = $this->posts->getSidebarSortedPosts();
        $this->data['most_common_tags'] = $this->tags->getMostCommonTags();
	}

	function index() {
        $this->data['posts'] = $this->posts->getAllPosts();
        $this->view->appendToLayout('posts', 'post.posts_template');
		$this->view->display('post.posts', $this->data, false);
	}
}