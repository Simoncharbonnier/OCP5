<?php

class Model {

  protected PDO $db;

  public function __construct() {
    try {
      $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
    catch(Exception $e) {
      die('Erreur : '.$e->getMessage());
    }
  }
}
