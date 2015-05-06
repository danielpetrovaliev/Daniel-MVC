<?php
namespace Models;

class Comment extends BaseModel{
    public function getCommentsForPost($id){
        $sql = "SELECT c.id,
                c.content,
                c.user_name,
                c.user_email,
                c.created
			FROM comments c
			WHERE c.post_id = ?";

        $result = $this->db->prepare($sql)->execute(array($id))->fetchAllAssoc();
        return $result;
    }

    public function add($commentData){
        $sql = "INSERT INTO comments(content, user_name, user_email, post_id) VALUES (?, ?, ?, ?)";

        $sqlParams[] = $commentData['content'];
        $sqlParams[] = $commentData['user_name'];
        $sqlParams[] = $commentData['user_email'];
        $sqlParams[] = $commentData['post_id'];

        $result = $this->db->prepare($sql)->execute($sqlParams)->getLastInsertId();
        return $result;
    }
}