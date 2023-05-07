<?php

require_once('app/models/Model.php');

class User_model extends Model {

  /**
   * Get all users
   */
  public function getAll() {
    $sql = "SELECT * FROM User";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Get a user by id
   */
  public function getById($id) {
    $sql = "SELECT * FROM User WHERE id = :user_id";
    $query = $this->db->prepare($sql);
    $query->bindParam(':user_id', $id);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Get a user by mail
   */
  public function getByMail($mail) {
    $sql = "SELECT * FROM User WHERE mail = :mail";
    $query = $this->db->prepare($sql);
    $query->bindParam(':mail', $mail);
    $query->execute();
    return $query->fetchAll();
  }

  /**
   * Create a user
   */
  public function create(array $data) {
      $sql = "INSERT INTO User (first_name, last_name, mail, password)
              VALUES (:first_name, :last_name, :mail, :password)";
      $query = $this->db->prepare($sql);
      $query->execute($data);
      return $this->db->lastInsertId();
  }

  /**
   * Update a user
   */
  public function update(array $data) {
    $sql = "UPDATE User SET first_name = :first_name, last_name = :last_name, password = :password, avatar = :avatar
            WHERE id = :id";
    $query = $this->db->prepare($sql);
    return $query->execute($data);
  }

  /**
   * Update admin of a user
   */
  public function updateAdmin(array $data) {
    $sql = "UPDATE User SET admin = :admin
            WHERE id = :id";
    $query = $this->db->prepare($sql);
    return $query->execute($data);
  }

  /**
   * Delete a user
   */
  public function delete($id) {
    $sql = "DELETE FROM User WHERE id = :user_id";
    $query = $this->db->prepare($sql);
    $query->bindParam(':user_id', $id);
    return $query->execute();
  }
}
