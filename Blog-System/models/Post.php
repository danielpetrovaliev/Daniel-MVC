<?php

namespace Models;

class Post extends BaseModel {

	public function getAllPosts() {
		$sql = "SELECT p.id as post_id,
				p.title as post_title,
			    p.content as post_content,
			    p.created as post_created,
			    u.id as user_id,
			    u.username as username
			FROM posts p
			JOIN users u ON p.user_id = u.id";

		$result = $this->db->prepare($sql)->execute()->fetchAllAssoc();

		return $result;
	}
}