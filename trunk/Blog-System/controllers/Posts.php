<?php

namespace Controllers;

use Models\Comment;
use Models\Post;
use Models\Tag;
use Models\User;

class Posts extends BaseController {
    /**
     * @var User Model
     */
    private $users;
    /**
     * @var Post Model
     */
    private $posts;
    /**
     * @var Comment Model
     */
    private $comments;
    /**
     * @var Tag Model
     */
    private $tags;

	function __construct() {
        parent::__construct();
		//$this->users = new User();
		$this->posts = new Post();
        $this->comments = new Comment();
        $this->tags = new Tag();

        // Side bar data
        $this->data['sorted_posts'] = $this->posts->getSidebarSortedPosts();
        $this->data['most_common_tags'] = $this->tags->getMostCommonTags();
	}

	public function get() {
		// Get first param from url
        $id = $this->input->get(0);
        if(!ctype_digit($id)){
            // TODO redirect
            die();
        }

        $this->data['post'] = $this->posts->getPost($id);

        if($this->data['post'] == null){
            // TODO redirect
            die();
        }

        $this->increaseVisits($id);

        $this->data['comments'] = $this->comments->getCommentsForPost($id);

        $this->view->appendToLayout("post", "post.post_template");
        $this->view->display("post.post", $this->data, false);
	}

    private function increaseVisits($id){
        $post = $this->posts->getPost($id);
        $visitsBeforeInc = $post['visits'];

        return $this->posts->increaseVisits($id, $visitsBeforeInc + 1);
    }

    public function getPostsByTagTitle(){
        $tagQuery = $_GET['tagQuery'];

        $this->data['posts'] = $this->posts->getPostsByTagTitle($tagQuery);
        $this->view->appendToLayout("posts", "post.posts_template");
        $this->view->display("post.posts", $this->data, false);
    }

    public function getByTag(){
        // Get first param from url
        $id = $this->input->get(0);
        if(!ctype_digit($id)){
            // TODO redirect
            die();
        }

        $this->data['posts'] = $this->posts->getPostsByTag($id);
        $this->view->appendToLayout("posts", "post.posts_template");
        $this->view->display("post.posts", $this->data, false);
    }

    public function add(){
        // TODO
    }
}