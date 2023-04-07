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
}
