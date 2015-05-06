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
}