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
  public function detail() : void {
    $postModel = New Post_model();
    $result = $postModel->getById($_GET['id']);

    if (empty($result)) {
      $this->index();
    } else {
      $post = [
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
    }
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
