<?php
/**
 * Created by PhpStorm.
 * User: petrovaliev95
 * Date: 06-May-15
 * Time: 7:09 PM
 */

namespace Models;


class Tag extends BaseModel{
    public function getMostCommonTags(){
        $sql = "SELECT *
                FROM  (SELECT tag_id, count(post_id) as cnt FROM daniel_blog.posts_tags
                GROUP BY tag_id
                order by count(post_id) DESC) tt
                JOIN tags t on t.id = tt.tag_id
                ORDER BY cnt DESC;";


        $result = $this->db->prepare($sql)->execute()->fetchAllAssoc();
        return $result;
    }

    public function getByTitle($title){
        $sql = "SELECT id,
              title
            FROM tags
            WHERE title = ?";

        $result = $this->db->prepare($sql)->execute(array($title))->fetchRowAssoc();
        return $result;
    }

    public function add($title){
        $sql = "INSERT INTO tags(title) VALUES(?)";

        $result = $this->db->prepare($sql)->execute(array($title))->getLastInsertId();
        return $result;
    }

    public function getByPost($post_id){
        $sql = "SELECT t.id,
                t.title
            FROM posts p
            RIGHT JOIN posts_tags pt ON pt.post_id = p.id
            RIGHT JOIN tags t ON pt.tag_id = t.id
            WHERE p.id = ?";

        $result = $this->db->prepare($sql)->execute(array($post_id))->fetchAllAssoc();
        return $result;
    }
}