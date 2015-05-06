<?php

namespace Controllers;

use Models\Comment;
use Models\Post;
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

	function __construct() {
        parent::__construct();
		//$this->users = new User();
		$this->posts = new Post();
        $this->comments = new Comment();
	}

	public function get() {
		// Get first param from url
        $id = $this->input->get(0);
        if(!ctype_digit($id)){
            // TODO redirect
            die();
        }

        $data['post'] = $this->posts->getPost($id);

        if($data['post'] == null){
            // TODO redirect
            die();
        }

        $data['comments'] = $this->comments->getCommentsForPost($id);

        $this->view->appendToLayout("post", "post.post_template");
        $this->view->display("post.post", $data, false);
	}

    public function add(){
        // TODO
    }
}