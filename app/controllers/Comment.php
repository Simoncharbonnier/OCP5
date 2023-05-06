<?php

require_once('app/controllers/Controller.php');

require_once('app/models/Comment_model.php');
require_once('app/models/Post_model.php');

class Comment extends Controller {

  /**
   * Retrieve all comments and display the list of comments
   * As an admin
   */
  public function index() : void {
    try {
      $this->isAdmin();

      $commentModel = New Comment_model();
      $comments = $commentModel->getAll();

      include_once('app/views/comment/index.php');
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=home&action=index");
      exit;
    }
  }

  /**
   * Add a comment and redirect to post->detail()
   */
  public function add() : void {
    try {
      if ($_GET['id']) {
        $postId = $_GET['id'];
        $postModel = New Post_model();
        $post = $postModel->getById($postId);

        if (!empty($post)) {
          $data = [];

          if (!empty($_POST) && (isset($_POST['message']) && !empty($_POST['message']))) {
            $data['message'] = $_POST['message'];
            $data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
            $data['post_id'] = $postId;
            $data['created_at'] = date("Y-m-d");

            $commentModel = New Comment_model();
            $commentModel->create($data);

            header("Location: http://localhost/P5/?controller=post&action=detail&id=" . $postId);
            exit;
          } else {
            throw new Exception("Il n'y a pas de message.");
          }
        } else {
          throw new Exception("Ce post n'existe pas.");
        }
      } else {
        throw new Exception("A quel post voulez-vous ajouter un commentaire ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=post&action=index");
      exit;
    }
  }

  /**
   * Update a comment by its id and redirect to index()
   * As an admin
   */
  public function edit() : void {
    try {
      $this->isAdmin();

      if ($_GET['id']) {
        $commentId = $_GET['id'];
        $commentModel = New Comment_model();
        $comment = $commentModel->getById($commentId);

        if (!empty($comment)) {
          $data = [];

          if ($comment[0]['valid']) {
            $data['valid'] = 0;
          } else {
            $data['valid'] = 1;
          }
          $data['id'] = $commentId;

          $commentModel->update($data);
        } else {
          throw new Exception("Le commentaire n'existe pas.");
        }
      } else {
        throw new Exception("Quel commentaire voulez-vous modifier ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    header("Location: http://localhost/P5/?controller=comment&action=index");
    exit;
  }

  /**
   * Delete a comment by its id and redirect to index()
   * As an admin
   */
  public function delete($commentId = NULL) : void {
    try {
      $this->isAdmin();

      $commentId = $commentId ? $commentId : $_GET['id'];

      if ($commentId) {
        $commentModel = New Comment_model();
        $comment = $commentModel->getById($commentId);

        if (!empty($comment)) {
          $commentModel->delete($commentId);
        } else {
          throw new Exception("Le commentaire n'existe pas.");
        }
      } else {
        throw new Exception("Quel commentaire voulez-vous supprimer ?");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    header("Location: http://localhost/P5/?controller=comment&action=index");
    exit;
  }
}
