<?php

require_once('app/models/Model.php');

class Comment_model extends Model {

  /**
   * Get all comments
   */
  public function getAll() {
    $sql = "SELECT Comment.id, Comment.message, Comment.created_at, Comment.valid,
                    User.first_name author, User.avatar author_avatar,
                    Post.id post_id, Post.title post_title
            FROM Comment
            JOIN User ON User.id = Comment.user_id
            JOIN Post ON Post.id = Comment.post_id
            ORDER BY valid";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Get a comment by id
   */
  public function getById($id) {
    $sql = "SELECT * FROM Comment WHERE id = :comment_id";
    $query = $this->db->prepare($sql);
    $query->bindParam(':comment_id', $id);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Create a comment
   */
  public function create(array $data) {
    $sql = "INSERT INTO Comment (user_id, post_id, message, created_at)
            VALUES (:user_id, :post_id, :message, :created_at)";
    $query = $this->db->prepare($sql);
    return $query->execute($data);
  }

  /**
   * Update a comment
   */
  public function update(array $data) {
    $sql = "UPDATE Comment SET valid = :valid WHERE id = :id";
    $query = $this->db->prepare($sql);
    return $query->execute($data);
  }

  /**
   * Delete a comment
   */
  public function delete($id) {
    $sql = "DELETE FROM Comment WHERE id = :id";
    $query = $this->db->prepare($sql);
    $query->bindParam(':id', $id);
    return $query->execute();
  }
}
