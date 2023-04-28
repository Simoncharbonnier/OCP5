<?php

require_once('app/controllers/Controller.php');

require_once('app/models/User_model.php');

class User extends Controller {

  /**
   * Add a user and redirect to user->login()
   */
  public function signup() : void {
    try {
      if (!empty($_POST) && (isset($_POST['first_name']) && !empty($_POST['first_name'])) && (isset($_POST['last_name']) && !empty($_POST['last_name'])) && (isset($_POST['mail']) && !empty($_POST['mail'])) && (isset($_POST['password']) && !empty($_POST['password']))) {
        if (isset($_POST['confirm']) && $_POST['password'] === $_POST['confirm']) {
          unset($_POST['confirm']);
          $userModel = New User_model();
          $user = $userModel->getByMail($_POST['mail']);

          if (empty($user)) {
            $passwordHash = password_hash($_POST['password'], CRYPT_BLOWFISH);
            foreach ($_POST as $name => $value) {
              $data[$name] = $value;
            }
            $data['password'] = $passwordHash;

            $userModel->create($data);
            header("Location: http://localhost/P5/?controller=user&action=login&form=login");
            exit;
          } else {
            throw new Exception("Un utilisateur utilise déjà cette adresse mail.");
          }
        } else {
          throw new Exception("Veuillez confirmer le mot de passe.");
        }
      } else {
        throw new Exception("Il manque des informations.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=user&action=login&form=signup");
      exit;
    }
  }

  /**
   * Verify the credentials and redirect to home->index()
   */
  public function login() : void {
    try {
      if (isset($_POST['mail']) && isset($_POST['password'])) {
        if (!empty($_POST['mail']) && !empty($_POST['password'])) {
          $userModel = New User_model();
          $user = $userModel->getByMail($_POST['mail']);

          if (!empty($user)) {
            $user = $user[0];
            $passwordHash = $user['password'];
            if (password_verify($_POST['password'], $passwordHash)) {
              $_SESSION['is_logged'] = true;
              $_SESSION['user_mail'] = $user['mail'];
              $_SESSION['user_avatar'] = $user['avatar'];
              $_SESSION['user_admin'] = $user['admin'];
              header("Location: http://localhost/P5/?controller=home&action=index");
              exit;
            } else {
              throw new Exception("Mot de passe incorrect.");
            }
          } else {
            throw new Exception("Mail incorrect.");
          }
        } else {
          throw new Exception("Identifiants manquants.");
        }
      } else {
        include_once('app/views/user/login.php');
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=user&action=login&form=login");
      exit;
    }
  }

  /**
   * Logout a user
   */
  public function logout() : void {
    try {
      if (isset($_SESSION) && $_SESSION['is_logged'] === true) {
        session_unset();
        session_destroy();
      }

      header("Location: http://localhost/P5/?controller=home&action=index");
      exit;
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=home&action=index");
      exit;
    }
  }

  /**
   * Retrieve all users and display the list of users
   * As an admin
   */
  public function index() : void {
    try {
      $this->isAdmin();

      $userModel = New User_model();
      $users = $userModel->getAll();

      include_once('app/views/user/index.php');
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=home&action=index");
      exit;
    }
  }

  /**
   * Retrieve a user by its id and display the detail of the user
   */
  public function detail() : void {
    try {
      $userModel = New User_model();
      $result = $userModel->getById($_GET['id']);

      if (!empty($result)) {
        $user = $result[0];

        include_once('app/views/user/detail.php');
      } else {
        throw new Exception("L'utilisateur n'existe pas.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=home&action=index");
      exit;
    }
  }

  /**
   * Update a user by its id and redirect to detail() or index()
   * As an admin or the user himself
   */
  public function edit() : void {
    try {
      // As an admin or the user himself
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=home&action=index");
      exit;
    }
  }

  /**
   * Delete a user by its id and redirect to index()
   * As an admin or the user himself
   */
  public function delete() : void {
    try {
      // As an admin or the user himself
      if ($_GET['id']) {
        $userModel = New User_model();
        $user = $userModel->getById($_GET['id']);

        if (!empty($user)) {
          // Delete comments & articles by user

          $userModel->delete($_GET['id']);
        } else {
          throw new Exception("L'utilisateur n'existe pas.");
        }
      } else {
        throw new Exception("Quel utilisateur voulez-vous supprimer ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    header("Location: http://localhost/P5/?controller=post&action=index");
    exit;
  }
}
