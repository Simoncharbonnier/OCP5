<?php

require_once('app/models/Comment_model.php');
require_once('app/models/Post_model.php');
require_once('app/controllers/Post.php');

class Comment {

  /**
   * Retrieve all comments and display the list of comments
   * As an admin
   */
  public function index() : void {

  }

  /**
   * Add a comment and redirect to post->detail()
   */
  public function add() : void {
    try {
      $postId = $_GET['id'];
      $postModel = New Post_model();
      $post = $postModel->getById($postId);

      if (!empty($post)) {
        $data = [];

        if (!empty($_POST) && (isset($_POST['message']) && !empty($_POST['message']))) {
          $data['message'] = $_POST['message'];
          $data['user_id'] = 1;
          $data['post_id'] = $postId;
          $data['created_at'] = date("Y-m-d");

          $commentModel = New Comment_model();
          $commentModel->create($data);

          header("Location: http://localhost/P5/?controller=post&action=detail&id=" . $postId);
        } else {
          throw new Exception("Il n'y a pas de message.");
        }
      } else {
        throw new Exception("Ce post n'existe pas.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
      header("Location: http://localhost/P5/?controller=post&action=index");
    }
  }

  /**
   * Update a comment by its id and redirect to index()
   * As an admin
   */
  public function update() : void {

  }

  /**
   * Delete a comment by its id and redirect to index()
   * As an admin
   */
  public function delete() : void {

  }
}
