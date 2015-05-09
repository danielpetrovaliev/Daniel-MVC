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

    function index() {
        $perPage = 2;
        $page = $_GET['page'] != null ? $_GET['page'] : 1;
        $offset = ((int)$page * (int)$perPage) - $perPage;

        $this->data['posts'] = $this->posts->getAllPosts($perPage, $offset);
        foreach ($this->data['posts'] as $key => $post) {
            $this->data['posts'][$key]['tags'] = $this->tags->getSeparatedTagsByPost($post['post_id']);

            // set length of content
            $this->data['posts'][$key]['post_content'] = substr($this->data['posts'][$key]['post_content'], 0, 300) . '...';
        }

        $this->data['posts_pages_count'] = $this->getPagesCount($this->posts->getAllPostsCount(), $perPage);

        $this->view->appendToLayout('posts', 'post.posts_template');
		$this->view->display('post.posts', $this->data, false);
	}

    // Get by id
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

        $this->data['post']['tags'] = $this->tags->getSeparatedTagsByPost($this->data['post']['post_id']);
        $this->data['comments'] = $this->comments->getCommentsForPost($id);
        $this->increaseVisits($id);

        $this->view->appendToLayout("post", "post.post_template");
        $this->view->display("post.post", $this->data, false);
	}

    private function increaseVisits($id){
        $post = $this->posts->getPost($id);
        $visitsBeforeInc = $post['visits'];

        return $this->posts->increaseVisits($id, $visitsBeforeInc + 1);
    }

    public function getPostsByTagTitle(){
        $perPage = 2;
        $page = $_GET['page'] != null ? $_GET['page'] : 1;
        $offset = ((int)$page * (int)$perPage) - $perPage;

        $tagQuery = $_GET['tagQuery'];

        $this->data['posts'] = $this->posts->getPostsByTagTitle($tagQuery, $perPage, $offset);

        $this->data['posts_pages_count'] = $this->getPagesCount($this->posts->getCountPostsByTagTitle($tagQuery), $perPage);

        foreach ($this->data['posts'] as $key => $post) {
            $this->data['posts'][$key]['tags'] = $this->tags->getSeparatedTagsByPost($post['post_id']);

            // set length of content
            $this->data['posts'][$key]['post_content'] = substr($this->data['posts'][$key]['post_content'], 0, 300) . '...';
        }

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

        $perPage = 2;
        $page = $_GET['page'] != null ? $_GET['page'] : 1;
        $offset = ((int)$page * (int)$perPage) - $perPage;


        $this->data['posts'] = $this->posts->getPostsByTag($id, $perPage, $offset);
        $this->data['posts_pages_count'] = $this->getPagesCount($this->posts->getPostsByTagCount($id), $perPage);

        foreach ($this->data['posts'] as $key => $post) {
            $this->data['posts'][$key]['tags'] = $this->tags->getSeparatedTagsByPost($post['post_id']);

            // set length of content
            $this->data['posts'][$key]['post_content'] = substr($this->data['posts'][$key]['post_content'], 0, 300) . '...';
        }

        $this->view->appendToLayout("posts", "post.posts_template");
        $this->view->display("post.posts", $this->data, false);
    }

    public function add(){
        // Authorization
        if($this->session->is_admin != 1){
            $this->redirect("/");
        }

        if($this->input->hasPost('submit')){
            $errors[] = array();
            $title = $this->input->post('title');
            $text = $this->input->post('text');
            $tags = $this->input->post('tags');
            $author_id = $this->session->user_id;

            // TODO Validate tag format and other fields

            $post_id = $this->posts->add($title, $text, $author_id);

            if($post_id > 0){
                $tagsAsArray = explode(', ', $tags);
                foreach($tagsAsArray as $tag){
                    $tagFromDb = $this->tags->getByTitle($tag);

                    // Tag exist
                    if($tagFromDb != null){
                        // Realation not exist
                        if(!$this->posts->isTagRelationExist($post_id, $tagFromDb['id'])){
                            $relation_id = $this->posts->addTagRelation($post_id, $tagFromDb['id']);
                            if(!$relation_id > 0){
                                $error = "Problem with relation creating.";
                            }
                        }
                    } else{
                        $tag_id = $this->tags->add($tag);

                        // When tag is created
                        if($tag_id > 0){
                            $relation_id = $this->posts->addTagRelation($post_id, $tag_id);
                            if(!$relation_id > 0){
                                $error = "Problem with relations between posts and tags";
                            }
                        } else{
                            $error = "Problem with tag creating.";
                        }
                    }
                }
            } else{
                $error = "Problem with post creating.";
            }

            if(isset($error) && $error != ''){
                $this->data['error'] = $error;
            } else{
                $this->redirect("/");
            }

        }

        $this->view->appendToLayout("add", "post.add_template");
        $this->view->display("post.add", $this->data, false);
    }

    private function getPagesCount($postsCount, $perPage){
        $pages = 0;

        if($postsCount <= $perPage){
            $pages = 1;
        } elseif($postsCount % $perPage != 0){
            $pages = $postsCount / $perPage + 1;
        } else{
            $pages = $postsCount / $perPage;
        }

        return $pages;
    }
}