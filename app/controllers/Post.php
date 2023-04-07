<?php

require_once('app/models/Post_model.php');
require_once('app/models/User_model.php');

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
  public function detail() : void {
    $postModel = New Post_model();
    $post = $postModel->getById($_GET['id']);

    if (empty($post)) {
      $this->index();
    } else {
      $post = $post[0];
    }

    $userModel = New User_model();
    $post['user'] = $userModel->getById($post['user_id'])[0];

    include_once('app/views/post/detail.php');
  }

  /**
   * Add a post and redirect to detail()
   * As an admin
   */
  public function add() : void {

  }

  /**
   * Update a post by its id and redirect to detail()
   * As an admin
   */
  public function update() : void {

  }

  /**
   * Delete a post by its id and redirect to index()
   * As an admin
   */
  public function delete() : void {

  }
}
