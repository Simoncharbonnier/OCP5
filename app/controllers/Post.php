<?php

require_once('app/models/Post_model.php');

class Post {

  /**
   * Retrieve all posts and display the list of posts
   */
  public function index() : void {
    $postModel = New Post_model();
    $posts = $postModel->getAll();

    include_once('app/views/post/index.php');
  }

  /**
   * Retrieve a post by its id and display the detail of the post
   */
  public function detail($id = NULL) : void {
    try {
      $id = $id !== NULL ? $id : $_GET['id'];

      $postModel = New Post_model();
      $result = $postModel->getById($id);

      if (!empty($result)) {
        $post = [
          'id' => $result[0]['id'],
          'title' => $result[0]['title'],
          'headline' => $result[0]['headline'],
          'content' => $result[0]['content'],
          'image' => $result[0]['image'],
          'created_at' => $result[0]['created_at'],
          'updated_at' => $result[0]['updated_at'],
          'author' => $result[0]['post_author'],
          'author_avatar' => $result[0]['post_author_avatar']
        ];

        $comments = [];

        if ($result[0]['message'] !== NULL) {
          foreach ($result as $comment) {
            $comments[] = [
              'message' => $comment['message'],
              'created_at' => $comment['comment_created_at'],
              'author' => $comment['comment_author'],
              'author_avatar' => $comment['comment_author_avatar']
            ];
          }
        }

        include_once('app/views/post/detail.php');
      } else {
        throw new Exception("Le post n'existe pas.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=post&action=index");
      exit;
    }
  }

  /**
   * Add a post and redirect to detail()
   * As an admin
   */
  public function add() : void {
    try {
      $data = [];

      if (!empty($_POST) && (isset($_POST['title']) && !empty($_POST['title'])) && (isset($_POST['headline']) && !empty($_POST['headline'])) && (isset($_POST['content']) && !empty($_POST['content']))) {
        $postModel = New Post_model();
        $postWithTitle = $postModel->getByTitle($_POST['title']);

        if (empty($postWithTitle)) {
          foreach ($_POST as $name => $value) {
            $data[$name] = $value;
          }
          $data['user_id'] = 1;
          $data['created_at'] = date("Y-m-d");
          $data['updated_at'] = date("Y-m-d H:i:s");

          if (!empty($_FILES['image']['name'])) {
            $allowed = array('image/jpeg', 'image/png');
            $type = $_FILES['image']['type'];

            if (in_array($type, $allowed)) {
              $fileName = 'post_' . $_POST['title'] . '.png';
              $currentPath = $_FILES['image']['tmp_name'];

              $data['image'] = $this->uploadImage($currentPath, $fileName);
            } else {
              $data['image'] = NULL;
            }
          } else {
            $data['image'] = NULL;
          }

          $postId = $postModel->create($data);
          header("Location: http://localhost/P5/?controller=post&action=detail&id=" . $postId);
          exit;
        } else {
          throw new Exception("Un article avec ce titre existe déjà.");
        }
      } else {
        throw new Exception("Des champs sont manquants.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=post&action=index");
      exit;
    }
  }

  /**
   * Edit a post by its id and redirect to detail()
   * As an admin
   */
  public function edit() : void {
    try {
      $data = [];
      $postId = $_GET['id'];
      $postModel = New Post_model();
      $post = $postModel->getById($postId);

      if (!empty($post)) {
        $post = $post[0];

        if (!empty($_POST) && (isset($_POST['title']) && !empty($_POST['title'])) && (isset($_POST['headline']) && !empty($_POST['headline'])) && (isset($_POST['content']) && !empty($_POST['content']))) {
          $postModel = New Post_model();
          $postWithTitle = $postModel->getByTitle($_POST['title'], $postId);

          if (empty($postWithTitle)) {
            foreach ($_POST as $name => $value) {
              if ($name !== 'image-changed') {
                $data[$name] = $value;
              }
            }
            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['id'] = $postId;

            $imgFileName = 'post_' . $_POST['title'] . '.png';

            if ($post['title'] !== $_POST['title'] && $post['image']) {
              $this->renameImage($post['image'], $imgFileName);
            }

            if ($_POST['image-changed'] === 'true') {
              if (!empty($_FILES['image']['name'])) {
                $allowed = array('image/png', 'image/jpeg');
                $type = $_FILES['image']['type'];
                if (in_array($type, $allowed)) {
                  $currentPath = $_FILES['image']['tmp_name'];

                  $data['image'] = $this->uploadImage($currentPath, $imgFileName);
                } else {
                  $data['image'] = NULL;
                  $this->deleteImage($imgFileName);
                }
              } else {
                $data['image'] = NULL;
                $this->deleteImage($imgFileName);
              }
            } else {
              $data['image'] = isset($oldPath) ? $imgFileName : $post['image'];
            }

            $postModel->update($data);
            header("Location: http://localhost/P5/?controller=post&action=detail&id=" . $postId);
            exit;
          } else {
            throw new Exception("Un article avec ce titre existe déjà.");
          }
        } else {
          throw new Exception("Des champs sont manquants.");
        }
      } else {
        throw new Exception("Le post n'existe pas.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      var_dump($message);die;
      header("Location: http://localhost/P5/?controller=post&action=index");
      exit;
    }
  }

  /**
   * Delete a post by its id and redirect to index()
   * As an admin
   */
  public function delete() : void {
    try {
      if ($_GET['id']) {
        $postModel = New Post_model();
        $post = $postModel->getById($_GET['id']);

        if (!empty($post)) {
          $this->deleteImage($post[0]['image']);

          $postModel->delete($_GET['id']);
        } else {
          throw new Exception("Le post n'existe pas.");
        }
      } else {
        throw new Exception("Quel post voulez-vous supprimer ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    header("Location: http://localhost/P5/?controller=post&action=index");
    exit;
  }

  private function uploadImage($currentPath, $newFileName) {
    $newPath = '/opt/lampp/htdocs/P5/assets/img/post/' . $newFileName;

    if (move_uploaded_file($currentPath, $newPath)) {
      return $newFileName;
    } else {
      return NULL;
    }
  }

  private function deleteImage($fileName) {
    $path = '/opt/lampp/htdocs/P5/assets/img/post/' . $fileName;

    if (file_exists($path)) {
      unlink($path);
    }
  }

  private function renameImage($oldFileName, $newFileName) {
    $path = '/opt/lampp/htdocs/P5/assets/img/post/';

    if (file_exists($path . $oldFileName)) {
      rename($path . $oldFileName, $path . $newFileName);
    }
  }
}
