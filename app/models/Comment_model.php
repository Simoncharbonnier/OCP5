<?php

require_once('app/models/Model.php');

class Comment_model extends Model {

    /**
   * Get valid comments by post id
   */
  public function getByPostId($postId) {
    $sql = "SELECT Comment.content, Comment.created_at, User.first_name, User.last_name, User.avatar
            FROM Comment
            JOIN User ON User.id = Comment.user_id
            WHERE Comment.post_id = $postId AND Comment.valid = 1";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }
}
