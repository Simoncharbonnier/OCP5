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
    }

    $this->index();
  }

  /**
   * Add a post and redirect to detail()
   * As an admin
   */
  public function add() : void {
    try {
      $data = [];
      if (!empty($_POST) && (isset($_POST['title']) && !empty($_POST['title'])) && (isset($_POST['headline']) && !empty($_POST['headline'])) && (isset($_POST['content']) && !empty($_POST['content']))) {
        foreach ($_POST as $name => $value) {
          $data[$name] = $value;
        }
        $data['user_id'] = 1;
        $data['image'] = NULL;
        $data['created_at'] = date("Y-m-d");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $postModel = New Post_model();
        $postId = $postModel->create($data);
        $this->detail($postId);
      } else {
        throw new Exception("Des champs sont manquants.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    $this->index();
  }

  /**
   * Edit a post by its id and redirect to detail()
   * As an admin
   */
  public function edit() : void {
    try {
      $postModel = New Post_model();
      $post = $postModel->getById($_GET['id']);

      if (!empty($post)) {
        $data = [];

        if (!empty($_POST) && (isset($_POST['title']) && !empty($_POST['title'])) && (isset($_POST['headline']) && !empty($_POST['headline'])) && (isset($_POST['content']) && !empty($_POST['content']))) {
          foreach ($_POST as $name => $value) {
            $data[$name] = $value;
          }
          $data['image'] = NULL;
          $data['updated_at'] = date("Y-m-d H:i:s");
          $data['id'] = $_GET['id'];

          $postModel->update($data);
        } else {
          throw new Exception("Des champs sont manquants.");
        }
      } else {
        throw new Exception("Le post n'existe pas.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }

    $this->detail($_GET['id']);
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

    $this->index();
  }
}
