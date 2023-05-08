<?php

require_once('app/controllers/Controller.php');
require_once('app/controllers/Comment.php');
require_once('app/controllers/Post.php');

require_once('app/models/User_model.php');
require_once('app/models/Comment_model.php');
require_once('app/models/Post_model.php');

class User extends Controller {

  /**
   * Add a user and redirect to the login page
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
            header("Location: " . PATH . "?controller=user&action=login&form=login&success=success_user_add");
            exit;
          } else {
            throw new Exception("user_exist");
          }
        } else {
          throw new Exception("password_confirm");
        }
      } else {
        throw new Exception("missing_param");
      }
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=user&action=login&form=signup&error=" . $e->getMessage());
      exit;
    }
  }

  /**
   * Verify the credentials and redirect to the home page
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
              header("Location: " . PATH . "?controller=home&action=index");
              exit;
            } else {
              throw new Exception("password_inval");
            }
          } else {
            throw new Exception("email_inval");
          }
        } else {
          throw new Exception("missing_param");
        }
      } else {
        include_once('app/views/user/login.php');
      }
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=user&action=login&form=login&error=" . $e->getMessage());
      exit;
    }
  }

  /**
   * Logout a user and redirect to the home page
   */
  public function logout() : void {
    try {
      $this->isLogged();
      session_unset();
      session_destroy();
      header("Location: " . PATH . "?controller=home&action=index");
      exit;
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=home&action=index&error=" . $e->getMessage());
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

      if (empty($users)) {
        throw new Exception("no_users");
      }

      include_once('app/views/user/index.php');
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=home&action=index&error=" . $e->getMessage());
      exit;
    }
  }

  /**
   * Retrieve a user by its id and display user detail
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
          throw new Exception("no_user");
        }
      } else {
        throw new Exception("inval");
      }
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=home&action=index&error=" . $e->getMessage());
      exit;
    }
  }

  /**
   * Update a user by its id and redirect to user detail
   * As the user himself
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

                header("Location: " . PATH . "?controller=user&action=detail&id=" . $user['id'] . "&success=success_user_edit");
                exit;
              } else {
                throw new Exception("password_confirm");
              }
            } else {
              throw new Exception("missing_param");
            }
          } else {
            throw new Exception("no_perms");
          }
        } else {
          throw new Exception("no_user");
        }
      } else {
        throw new Exception("inval");
      }
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=user&action=detail&id=" . $_GET['id'] . "&error=" . $e->getMessage());
      exit;
    }
  }

  /**
   * Delete a user by its id and redirect to users index
   * As an admin
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

              header("Location: " . PATH . "?controller=user&action=index&success=success_user_delete");
              exit;
            } else {
              throw new Exception("user_admin");
            }
          } else {
            throw new Exception("no_perms");
          }
        } else {
          throw new Exception("no_user");
        }
      } else {
        throw new Exception("inval");
      }
    } catch(Exception $e) {
      header("Location: " . PATH . "?controller=user&action=index&error=" . $e->getMessage());
      exit;
    }
  }

  private function uploadAvatar($currentPath, $newFileName) {
    $newPath = IMAGE_PATH . "user/" . $newFileName;

    if (move_uploaded_file($currentPath, $newPath)) {
      return $newFileName;
    } else {
      return 'default.jpg';
    }
  }

  private function deleteAvatar($fileName) {
    $path = IMAGE_PATH . "user/"  . $fileName;

    if (file_exists($path)) {
      unlink($path);
    }
  }

  private function deleteImage($fileName) {
    $path = IMAGE_PATH . "post/"  . $fileName;

    if (file_exists($path)) {
      unlink($path);
    }
  }
}
