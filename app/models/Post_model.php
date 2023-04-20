<?php

require_once('app/models/Model.php');

class Post_model extends Model {

  /**
   * Get all posts
   */
  public function getAll() {
    $sql = "SELECT * FROM Post";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Get a post by id with its comments
   */
  public function getById($id) {
    $sql = "SELECT Post.id, Post.title, Post.headline, Post.content, Post.image, Post.created_at, Post.updated_at,
                    User.first_name post_author, User.avatar post_author_avatar,
                    Comment.message, Comment.created_at comment_created_at,
                    U.first_name comment_author, U.avatar comment_author_avatar
            FROM Post
            JOIN User ON User.id = Post.user_id
            LEFT JOIN Comment ON Comment.post_id = Post.id
            LEFT JOIN User U ON U.id = Comment.user_id
            WHERE Post.id = :post_id AND (Comment.valid = 1 OR Comment.valid IS NULL)";
    $query = $this->db->prepare($sql);
    $query->bindParam(':post_id', $id);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Create a post
   */
  public function create(array $data) {
    $sql = "INSERT INTO Post (user_id, title, headline, content, image, created_at, updated_at)
            VALUES (:user_id, :title, :headline, :content, :image, :created_at, :updated_at)";
    $query = $this->db->prepare($sql);
    $query->execute($data);
    return $this->db->lastInsertId();
  }

  /**
   * Update a post
   */
  public function update(array $data) {
    $sql = "UPDATE Post SET title = :title, headline = :headline, content = :content, image = :image, updated_at = :updated_at
            WHERE id = :id";
    $query = $this->db->prepare($sql);
    return $query->execute($data);
  }

  /**
   * Delete a post
   */
  public function delete($id) {
    $sql = "DELETE FROM Post WHERE id = :post_id";
    $query = $this->db->prepare($sql);
    $query->bindParam(':post_id', $id);
    return $query->execute();
  }
}
