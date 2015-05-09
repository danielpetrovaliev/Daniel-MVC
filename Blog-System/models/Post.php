<?php

namespace Models;

class Post extends BaseModel {

	public function getAllPosts($limit, $offset) {
        $limit = intval($limit);
        $offset = intval($offset);

		$sql = "SELECT p.id as post_id,
				p.title as post_title,
			    p.content as post_content,
			    p.created as post_created,
			    u.id as user_id,
			    u.username as username,
			    p.visits as visits
			FROM posts p
			JOIN users u ON p.user_id = u.id
			ORDER BY post_created DESC
			LIMIT $limit OFFSET $offset";

		$result = $this->db->prepare($sql)->execute()->fetchAllAssoc();
		return $result;
	}

    public function getAllPostsCount() {
        $sql = "SELECT COUNT(p.id) as cnt
			FROM posts p
			JOIN users u ON p.user_id = u.id";

        $result = $this->db->prepare($sql)->execute()->fetchRowAssoc();
        return $result['cnt'];
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

    public function getPostsByTag($id, $limit, $offset){
        $limit = intval($limit);
        $offset = intval($offset);

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
        WHERE t.id = ?
        LIMIT $limit OFFSET $offset";

        $result = $this->db->prepare($sql)->execute(array($id))->fetchAllAssoc();
        return $result;
    }

    public function getPostsByTagCount($id){
        $sql = "SELECT COUNT(p.id) as cnt
        FROM posts p
        JOIN users u ON p.user_id = u.id
        RIGHT JOIN posts_tags pt ON p.id = pt.post_id
        RIGHT JOIN tags t ON t.id = pt.tag_id
        WHERE t.id = ?";

        $result = $this->db->prepare($sql)->execute(array($id))->fetchRowAssoc();
        return $result['cnt'];
    }

    public function getPostsByTagTitle($tagQuery, $limit, $offset){
        $limit = intval($limit);
        $offset = intval($offset);

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
            WHERE t.title like '%" . $tagQuery . "%'
            LIMIT $limit OFFSET $offset";

        $result = $this->db->prepare($sql)->execute()->fetchAllAssoc();
        return $result;
    }

    public function getCountPostsByTagTitle($tagQuery){
        $sql = "SELECT COUNT(p.id) as cnt
            FROM posts p
            JOIN users u ON u.id = p.user_id
            LEFT JOIN posts_tags pt ON p.id = pt.post_id
            LEFT JOIN tags t ON pt.tag_id = t.id
            WHERE t.title like '%" . $tagQuery . "%'";

        $result = $this->db->prepare($sql)->execute(array($tagQuery))->fetchRowAssoc();
        return $result['cnt'];
    }

    public function increaseVisits($id, $visits){
        $sql = "UPDATE posts
          SET visits = ?
          WHERE id = ?";

        $result = $this->db->prepare($sql)->execute(array($visits, $id))->getAffectedRows();
        return $result;
    }

    public function add($title, $text, $user_id){
        $sql = "INSERT INTO posts(title, content, user_id) VALUES(?, ?, ?)";

        $result = $this->db->prepare($sql)->execute(array($title, $text, $user_id))->getLastInsertId();
        return $result;
    }

    public function addTagRelation($post_id, $tag_id){
        $sql = "INSERT INTO posts_tags(post_id, tag_id) VALUES(?, ?)";

        $result = $this->db->prepare($sql)->execute(array($post_id, $tag_id))->getLastInsertId();
        return $result;
    }

    public function isTagRelationExist($post_id, $tag_id){
        $sql = "SELECT id
            FROM posts_tags
            WHERE post_id = ? AND tag_id = ?";

        $result = $this->db->prepare($sql)->execute(array($post_id, $tag_id))->fetchRowNum();
        return $result > 0 ? TRUE : FALSE;
    }
}