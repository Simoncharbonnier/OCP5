<?php

class Controller {

  public function isLogged() {
    if ($_SESSION['is_logged'] === true) {
      return true;
    } else {
      throw new Exception("Vous n'avez pas les permissions.");
    }
  }

  public function isAdmin() {
    if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) {
      return true;
    } else {
      throw new Exception("Vous n'avez pas les permissions.");
    }
  }
}
