<?php

class Controller {

  /**
   * Check if user id logged
   */
  public function isLogged() {
    if ($_SESSION['is_logged'] === true) {
      return true;
    } else {
      throw new Exception("no_perms");
    }
  }

  /**
   * Check if user id logged and admin
   */
  public function isAdmin() {
    if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) {
      return true;
    } else {
      throw new Exception("no_perms");
    }
  }
}
