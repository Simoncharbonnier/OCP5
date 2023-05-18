<?php

require_once 'app/controllers/Controller.php';

require_once 'app/models/Comment_model.php';
require_once 'app/models/Post_model.php';

class Comment extends Controller
{

    /**
	 * Retrieve all comments and display comments index
	 * As an admin
	 */

	public function index() : void
	{
		try {
			$this->isAdmin();

			$commentModel = new Comment_model();
			$comments = $commentModel->getAll();

			if (empty($comments)) {
				throw new Exception("no_comments");
			}

			include_once 'app/views/comment/index.php';
		} catch(Exception $e) {
			header("Location: " . PATH . "?controller=home&action=index&error=" . $e->getMessage());
			exit;
		}
	}

	/**
	 * Add a comment and redirect to post detail
	 * As a user
	 */

	public function add() : void
	{
		try {
			$this->isLogged();

			if ($_GET['id']) {
				$postId = $_GET['id'];
				$postModel = new Post_model();
				$post = $postModel->getById($postId);

				if (!empty($post)) {
					$data = [];

					if (!empty($_POST) && (isset($_POST['message']) && !empty($_POST['message']))) {
						$data['message'] = $_POST['message'];
						$data['user_id'] = $_SESSION['user_id'];
						$data['post_id'] = $postId;
						$data['created_at'] = date("Y-m-d");

						$commentModel = new Comment_model();
						$commentModel->create($data);

						header("Location: " . PATH . "?controller=post&action=detail&id=" . $postId . "&success=success_comment_add");
						exit;
					} else {
						throw new Exception("missing_param");
					}
				} else {
					throw new Exception("no_post");
				}
			} else {
				throw new Exception("inval");
			}
		} catch(Exception $e) {
			header("Location: " . PATH . "?controller=post&action=index&error=" . $e->getMessage());
			exit;
		}
	}

	/**
	 * Update a comment by its id and redirect to comments index
	 * As an admin
	 */

	public function edit() : void
	{
		try {
			$this->isAdmin();

			if ($_GET['id']) {
				$commentId = $_GET['id'];
				$commentModel = new Comment_model();
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

					header("Location: " . PATH . "?controller=comment&action=index&success=success_comment_edit");
					exit;
				} else {
					throw new Exception("no_comment");
				}
			} else {
				throw new Exception("inval");
			}
		} catch(Exception $e) {
			header("Location: " . PATH . "?controller=comment&action=index&error=" . $e->getMessage());
			exit;
		}
	}

	/**
	 * Delete a comment by its id and redirect to comments index
	 * As an admin
	 */

	public function delete($commentId = NULL) : void
	{
		try {
			$this->isAdmin();

			$commentId = $commentId ? $commentId : $_GET['id'];

			if ($commentId) {
				$commentModel = new Comment_model();
				$comment = $commentModel->getById($commentId);

				if (!empty($comment)) {
					$commentModel->delete($commentId);
					header("Location: " . PATH . "?controller=comment&action=index&success=success_comment_delete");
					exit;
				} else {
					throw new Exception("no_comment");
				}
			} else {
				throw new Exception("inval");
			}
		} catch(Exception $e) {
			header("Location: " . PATH . "?controller=comment&action=index&error=" . $e->getMessage());
			exit;
		}
	}
}
