<?php

require_once 'app/controllers/Controller.php';

require_once 'app/models/Comment_Model.php';
require_once 'app/models/Post_Model.php';

class Comment extends Controller
{

    /**
     * Retrieve all comments and display comments index as an admin
     *
     * @return void
     * @throws Exception
     */

    public function index() : void
    {
        try {
            $this->isAdmin();

            $commentModel = new Comment_Model();
            $comments = $commentModel->getAll();

            if (empty($comments) === FALSE) {
                include_once 'app/views/comment/index.php';
                return;
            }

            throw new Exception("no_comments");
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Add a comment and redirect to post detail
     * As a user
     *
     * @return void
     * @throws Exception
     */

    public function add() : void
    {
        try {
            $this->isLogged();

            if (isset($_GET['id']) === TRUE) {
                $postId = $_GET['id'];
                $postModel = new Post_Model();
                $post = $postModel->getById($postId);

                if (empty($post) === FALSE) {
                    $datas = [];

                    if (empty($_POST) === FALSE && (isset($_POST['message']) === TRUE && empty($_POST['message']) === FALSE)) {
                        $datas['message'] = $_POST['message'];
                        $datas['user_id'] = $_SESSION['user_id'];
                        $datas['post_id'] = $postId;
                        $datas['created_at'] = date("Y-m-d");

                        $commentModel = new Comment_Model();
                        $commentModel->create($datas);

                        header("Location: ".PATH."?controller=post&action=detail&id=".$postId."&success=success_comment_add");
                        exit;
                    }
                    throw new Exception("missing_param");
                }
                throw new Exception("no_post");
            }
            throw new Exception("inval");
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=post&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Update a comment by its id and redirect to comments index as an admin
     *
     * @return void
     * @throws Exception
     */

    public function edit() : void
    {
        try {
            $this->isAdmin();

            if (isset($_GET['id']) === TRUE) {
                $commentId = $_GET['id'];
                $commentModel = new Comment_Model();
                $comment = $commentModel->getById($commentId);

                if (empty($comment) === FALSE) {
                    $datas = [];

                    $datas['valid'] = ($comment[0]['valid'] === 1) ? 0 : 1;
                    $datas['id'] = $commentId;

                    $commentModel->update($datas);

                    header("Location: ".PATH."?controller=comment&action=index&success=success_comment_edit");
                    exit;
                } else {
                    throw new Exception("no_comment");
                }
            } else {
                throw new Exception("inval");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=comment&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Delete a comment by its id and redirect to comments index as an admin
     * @param ?integer $commentId id of the comment to delete
     *
     * @return void
     * @throws Exception
     */

    public function delete($commentId = NULL) : void
    {
        try {
            $this->isAdmin();

            $commentId = $commentId !== NULL ? $commentId : $_GET['id'];

            if ($commentId !== NULL) {
                $commentModel = new Comment_Model();
                $comment = $commentModel->getById($commentId);

                if (empty($comment) === FALSE) {
                    $commentModel->delete($commentId);
                    header("Location: ".PATH."?controller=comment&action=index&success=success_comment_delete");
                    exit;
                } else {
                    throw new Exception("no_comment");
                }
            } else {
                throw new Exception("inval");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=comment&action=index&error=".$e->getMessage());
            exit;
        }
    }
}
