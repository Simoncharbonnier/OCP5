<?php

require_once('app/models/Model.php');

class Post_model extends Model {

  /**
   * Get all posts
   */
  public function getAll() {
    $sql = "SELECT *
            FROM Post";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Get a post by id
   */
  public function getById($id) {
    $sql = "SELECT Post.title, Post.headline, Post.content, Post.image, Post.created_at, Post.updated_at, User.first_name, User.last_name, User.avatar
            FROM Post
            Join User On User.id = Post.user_id
            WHERE Post.id = $id";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }
}
