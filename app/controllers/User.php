<?php

require_once('app/controllers/Controller.php');
require_once('app/controllers/Comment.php');
require_once('app/controllers/Post.php');

require_once('app/models/User_model.php');
require_once('app/models/Comment_model.php');
require_once('app/models/Post_model.php');

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
              $_SESSION['user_id'] = $user['id'];
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
      $this->isLogged();
      session_unset();
      session_destroy();
    } catch(Exception $e) {
      $message = $e->getMessage();
    }
    header("Location: http://localhost/P5/?controller=home&action=index");
    exit;
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
      if ($_GET['id']) {
        $userModel = New User_model();
        $result = $userModel->getById($_GET['id'], true);

        if (!empty($result)) {
          $user = $result[0];

          if ($user['admin']) {
            $postModel = New Post_model();
            $posts = $postModel->getByUser($user['id']);
          }

          $commentModel = New Comment_model();
          $result = $commentModel->getByUser($user['id']);
          $comments = [];
          foreach ($result as $comment) {
            if ($comment['valid']) {
              $post = $postModel->getById($comment['post_id'])[0];
              $comment['post_title'] = $post['title'];
              $comment['post_id'] = $post['id'];
              $comments[] = $comment;
            }
          }

          include_once('app/views/user/detail.php');
        } else {
          throw new Exception("L'utilisateur n'existe pas.");
        }
      } else {
        throw new Exception("Quel utilisateur voulez-vous voir ?");
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
      $this->isLogged();

      if ($_GET['id']) {
        $userModel = New User_model();
        $user = $userModel->getById($_GET['id']);
        if (!empty($user)) {
          $user = $user[0];

          if ($_SESSION['user_mail'] === $user['mail']) {
            if (!empty($_POST) && (isset($_POST['first_name']) && !empty($_POST['first_name'])) && (isset($_POST['last_name']) && !empty($_POST['last_name'])) && (isset($_POST['password']) && !empty($_POST['password'])) && (isset($_POST['confirm']) && !empty($_POST['confirm'])) && (isset($_POST['avatar']) && !empty($_POST['avatar']))) {
              if ($_POST['password'] === $_POST['confirm']) {
                unset($_POST['confirm']);

                foreach ($_POST as $name => $value) {
                  if ($name !== 'admin') {
                    $data[$name] = $value;
                  }
                }
                $passwordHash = password_hash($_POST['password'], CRYPT_BLOWFISH);
                $data['password'] = $passwordHash;
                $data['id'] = $user['id'];

                if ($_POST['avatar'] !== $user['avatar']) {
                  if ($_POST['avatar'] !== 'default.jpg') {
                    $allowed = array('image/png', 'image/jpeg');
                    $type = $_FILES['image']['type'];
                    if (in_array($type, $allowed)) {
                      $currentPath = $_FILES['image']['tmp_name'];

                      $data['avatar'] = $this->uploadAvatar($currentPath, 'user_' . $user['id'] . '.jpg');
                    }
                  } else {
                    $this->deleteAvatar($user['avatar']);
                  }
                }

                $userModel->update($data);

                $_SESSION['user_avatar'] = $data['avatar'];

                header("Location: http://localhost/P5/?controller=user&action=detail&id=" . $user['id']);
                exit;
              } else {
                throw new Exception("Veuillez confirmer le mot de passe.");
              }
            } else {
              throw new Exception("Il manque des informations.");
            }
          } else {
            throw new Exception("Vous n'avez pas les permissions.");
          }
        } else {
          throw new Exception("L'utilisateur n'existe pas.");
        }
      } else {
        throw new Exception("Quel utilisateur voulez-vous modifier ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      var_dump($message);die;
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
      if ($_GET['id']) {
        $userModel = New User_model();
        $result = $userModel->getById($_GET['id']);

        if (!empty($result)) {
          $user = $result[0];
          if ($_SESSION['is_logged'] === true && ($_SESSION['user_admin'] === 1 || $_SESSION['user_mail'] === $user['mail'])) {
            if (!$user['admin']) {
              $commentModel = New Comment_model();
              $comments = $commentModel->getByUser($_GET['id']);

              foreach ($comments as $comment) {
                $commentModel->delete($comment['id']);
              }

              $postModel = New Post_model();
              $posts = $postModel->getByUser($_GET['id']);

              foreach ($posts as $post) {
                $postModel->delete($post['id']);
                if ($post['image']) {
                  $this->deleteImage($post['image']);
                }
              }

              if ($user['avatar'] !== 'default.jpg') {
                $this->deleteAvatar($user['avatar']);
              }

              $userModel->delete($_GET['id']);

              if ($_SESSION['user_mail'] === $user['mail']) {
                session_unset();
                session_destroy();
              }
            } else {
              throw new Exception("L'utilisateur est un administrateur.");
            }
          } else {
            throw new Exception("Vous n'avez pas les permissions.");
          }
        } else {
          throw new Exception("L'utilisateur n'existe pas.");
        }
      } else {
        throw new Exception("Quel utilisateur voulez-vous supprimer ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    header("Location: http://localhost/P5/?controller=user&action=index");
    exit;
  }

  private function uploadAvatar($currentPath, $newFileName) {
    $newPath = '/opt/lampp/htdocs/P5/assets/img/user/' . $newFileName;

    if (move_uploaded_file($currentPath, $newPath)) {
      return $newFileName;
    } else {
      return 'default.jpg';
    }
  }

  private function deleteAvatar($fileName) {
    $path = '/opt/lampp/htdocs/P5/assets/img/user/' . $fileName;

    if (file_exists($path)) {
      unlink($path);
    }
  }

  private function deleteImage($fileName) {
    $path = '/opt/lampp/htdocs/P5/assets/img/post/' . $fileName;

    if (file_exists($path)) {
      unlink($path);
    }
  }
}
