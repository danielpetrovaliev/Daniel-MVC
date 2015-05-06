<?php

namespace Models;

class Post extends BaseModel {

	public function getAllPosts() {
		$sql = "SELECT p.id as post_id,
				p.title as post_title,
			    p.content as post_content,
			    p.created as post_created,
			    u.id as user_id,
			    u.username as username,
			    p.visits as visits
			FROM posts p
			JOIN users u ON p.user_id = u.id";

		$result = $this->db->prepare($sql)->execute()->fetchAllAssoc();
		return $result;
	}

    public function getSidebarSortedPosts(){
        $sql = "SELECT p.id as post_id,
				p.title as post_title,
			    p.created as post_created,
			    u.id as user_id,
			    u.username as username
			FROM posts p
			JOIN users u ON p.user_id = u.id
			ORDER BY post_created DESC
			LIMIT 10";

        $result = $this->db->prepare($sql)->execute()->fetchAllAssoc();
        return $result;
    }

    public function getPost($id){
        $sql = "SELECT p.id as post_id,
				p.title as post_title,
			    p.content as post_content,
			    p.created as post_created,
			    u.id as user_id,
			    u.username as username,
			    p.visits as visits
			FROM posts p
			JOIN users u ON p.user_id = u.id
			WHERE p.id = ?";

        $result = $this->db->prepare($sql)->execute(array($id))->fetchRowAssoc();
        return $result;
    }

    public function getPostsByTag($id){
        $sql = "SELECT p.id as post_id,
            p.title as post_title,
            p.content as post_content,
            p.created as post_created,
            u.id as user_id,
            u.username as username,
            p.visits as visits
        FROM posts p
        JOIN users u ON p.user_id = u.id
        RIGHT JOIN posts_tags pt ON p.id = pt.post_id
        RIGHT JOIN tags t ON t.id = pt.tag_id
        WHERE t.id = ?";

        $result = $this->db->prepare($sql)->execute(array($id))->fetchAllAssoc();
        return $result;
    }

    public function getPostsByTagTitle($tagQuery){
        $sql = "SELECT p.id as post_id,
                p.title as post_title,
                p.content as post_content,
                p.created as post_created,
                u.id as user_id,
                u.username as username,
                p.visits as visits
            FROM posts p
            JOIN users u ON u.id = p.user_id
            LEFT JOIN posts_tags pt ON p.id = pt.post_id
            LEFT JOIN tags t ON pt.tag_id = t.id
            WHERE t.title like '%" . $tagQuery . "%'";

        $result = $this->db->prepare($sql)->execute(array($tagQuery))->fetchAllAssoc();
        return $result;
    }

    public function increaseVisits($id, $visits){
        $sql = "UPDATE posts
          SET visits = ?
          WHERE id = ?";

        $result = $this->db->prepare($sql)->execute(array($visits, $id))->getAffectedRows();
        return $result;
    }
}