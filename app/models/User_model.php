<?php

require_once('app/models/Model.php');

class User_model extends Model {

  /**
   * Get a user by id
   */
  public function getById($id) {
    $sql = "SELECT User.first_name, User.last_name, User.mail, User.avatar
            FROM User
            WHERE id = :user_id";
    $query = $this->db->prepare($sql);
    $query->bindParam(':user_id', $id);
    $query->execute();
    return $query->fetchAll();
  }
}
