<?php
namespace Controllers;

use \Models\Comment;


class Comments extends BaseController{
    /**
     * @var Comment Model
     */
    private $comments;

    function __construct() {
        parent::__construct();
        $this->comments = new Comment();
    }

    public function add(){
        // TODO Validation !!!
        $post_id = $this->input->get(0);
        $commentData['content'] = $this->input->post("content");
        $commentData['user_name'] = $this->input->post("user_name");
        $commentData['user_email'] = $this->input->post("user_email");
        $commentData['post_id'] = $post_id;

        $comment_id = $this->comments->add($commentData);

        if(isset($comment_id) && $comment_id != ''){
            $this->redirect("/");
        }
        else{
            // TODO SET ERROR
        }

    }
}