<?php

class Model {

  protected PDO $db;

  public function __construct() {
    try {
      $this->db = new PDO('mysql:host=localhost;dbname=OCP5;charset=utf8',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
    catch(Exception $e) {
      die('Erreur : '.$e->getMessage());
    }
  }
}
