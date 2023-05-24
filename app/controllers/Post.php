<?php

require_once 'app/controllers/Controller.php';

require_once 'app/models/Post_model.php';
require_once 'app/models/Comment_model.php';

class Post extends Controller
{

    /**
     * Retrieve all posts and display posts index
     *
     * @return void
     * @throws Exception
     */

    public function index() : void
    {
        try {
            $postModel = new Post_model();
            $posts = $postModel->getAll();

            if (empty($posts) === TRUE) {
                throw new Exception("no_posts");
            }

            include_once 'app/views/post/index.php';
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Retrieve a post by its id and display post detail
     *
     * @return void
     * @throws Exception
     */

    public function detail() : void
    {
        try {
            if (isset($_GET['id']) === TRUE) {
                $postId = $_GET['id'];
                $postModel = new Post_model();
                $result = $postModel->getById($postId);

                if (empty($result) === FALSE) {
                    $post = [
                             'id'            => $result[0]['id'],
                             'title'         => $result[0]['title'],
                             'headline'      => $result[0]['headline'],
                             'content'       => $result[0]['content'],
                             'image'         => $result[0]['image'],
                             'created_at'    => $result[0]['created_at'],
                             'updated_at'    => $result[0]['updated_at'],
                             'author_id'     => $result[0]['post_author_id'],
                             'author'        => $result[0]['post_author'],
                             'author_avatar' => $result[0]['post_author_avatar']
                            ];

                    $comments = [];
                    if ($result[0]['message'] !== NULL) {
                        foreach ($result as $comment) {
                            $comments[] = [
                                           'message'       => $comment['message'],
                                           'created_at'    => $comment['comment_created_at'],
                                           'author_id'     => $comment['comment_author_id'],
                                           'author'        => $comment['comment_author'],
                                           'author_avatar' => $comment['comment_author_avatar']
                                          ];
                        }
                    }

                    include_once 'app/views/post/detail.php';
                } else {
                    throw new Exception("no_post");
                }
            } else {
                throw new Exception("inval");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=post&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Add a post and redirect to post detail as an admin
     *
     * @return void
     * @throws Exception
     */

    public function add() : void
    {
        try {
            $this->isAdmin();

            if (empty($_POST) === FALSE && (isset($_POST['title']) === TRUE && empty($_POST['title']) === FALSE) && (isset($_POST['headline']) === TRUE && empty($_POST['headline']) === FALSE) && (isset($_POST['content']) === TRUE && empty($_POST['content']) === FALSE)) {
                $postModel = new Post_model();
                $sameTitle = $postModel->getByTitle($_POST['title']);

                if (empty($sameTitle) === TRUE) {
                    $data = [];
                    foreach ($_POST as $name => $value) {
                        $data[$name] = $value;
                    }
                    $data['user_id'] = $_SESSION['user_id'];
                    $data['created_at'] = date("Y-m-d");
                    $data['updated_at'] = date("Y-m-d");

                    if (empty($_FILES['image']['name']) === FALSE) {
                        $allowed = array('image/jpeg', 'image/png');
                        $type = $_FILES['image']['type'];

                        if (in_array($type, $allowed) === TRUE) {
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
                    header("Location: ".PATH."?controller=post&action=detail&id=".$postId."&success=success_post_add");
                    exit;
                } else {
                    throw new Exception("post_exist");
                }
            } else {
                throw new Exception("missing_param");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=post&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Edit a post by its id and redirect to post detail as an admin
     *
     * @return void
     * @throws Exception
     */

    public function edit() : void
    {
        try {
            $this->isAdmin();

            if (isset($_GET['id']) === TRUE) {
                $postId = $_GET['id'];
                $postModel = new Post_model();
                $post = $postModel->getById($postId);

                if (empty($post) === FALSE) {
                    $post = $post[0];

                    if (empty($_POST) === FALSE && (isset($_POST['title']) === TRUE && empty($_POST['title']) === FALSE) && (isset($_POST['headline']) === TRUE && empty($_POST['headline']) === FALSE) && (isset($_POST['content']) === TRUE && empty($_POST['content']) === FALSE)) {
                        $postModel = new Post_model();
                        $sameTitle = $postModel->getByTitle($_POST['title'], $postId);

                        if (empty($sameTitle) === FALSE) {
                            $data = [];
                            foreach ($_POST as $name => $value) {
                                if ($name !== 'image-changed') {
                                    $data[$name] = $value;
                                }
                            }
                            $data['updated_at'] = date("Y-m-d");
                            $data['id'] = $postId;

                            $imgFileName = 'post_' . $_POST['title'] . '.png';

                            if ($post['title'] !== $_POST['title'] && $post['image']) {
                                $this->renameImage($post['image'], $imgFileName);
                            }

                            if ($_POST['image-changed'] === 'true') {
                                if (!empty($_FILES['image']['name'])) {
                                    $allowed = ['image/png', 'image/jpeg'];
                                    $type = $_FILES['image']['type'];
                                    if (in_array($type, $allowed) === TRUE) {
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
                                $data['image'] = $imgFileName;
                            }

                            $postModel->update($data);
                            header("Location: ".PATH."?controller=post&action=detail&id=".$postId."&success=success_post_edit");
                            exit;
                        } else {
                            throw new Exception("post_exist");
                        }
                    } else {
                        throw new Exception("missing_param");
                    }
                } else {
                    throw new Exception("no_post");
                }
            } else {
                throw new Exception("inval");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=post&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Delete a post by its id and redirect to post index as an admin
     *
     * @return void
     * @throws Exception
     */

    public function delete($postId = NULL) : void
    {
        try {
            $this->isAdmin();

            $postId = $postId ? $postId : $_GET['id'];

            if ($postId !== NULL) {
                $postModel = new Post_model();
                $post = $postModel->getById($postId);

                if (empty($post) === FALSE) {
                    $post = $post[0];

                    $commentModel = new Comment_model();
                    $comments = $commentModel->getByPost($post['id']);
                    foreach ($comments as $comment) {
                        $commentModel->delete($comment['id']);
                    }

                    if ($post['image'] !== NULL) {
                        $this->deleteImage($post['image']);
                    }

                    $postModel->delete($postId);
                    header("Location: ".PATH."?controller=post&action=index&success=success_post_delete");
                    exit;
                } else {
                    throw new Exception("no_post");
                }
            } else {
                throw new Exception("inval");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=post&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Upload post image and return filename
     *
     * @return ?string
     */

    private function uploadImage($currentPath, $newFileName) : ?string
    {
        $newPath = IMAGE_PATH."post/".$newFileName;

        if (move_uploaded_file($currentPath, $newPath) === TRUE) {
            return $newFileName;
        } else {
            return NULL;
        }
    }


    /**
     * Delete post image
     *
     * @return void
     */

    private function deleteImage($fileName) : void
    {
        $path = IMAGE_PATH."post/".$fileName;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Rename image
     *
     * @return void
     */

    private function renameImage($oldFileName, $newFileName) : void
    {
        if (file_exists(IMAGE_PATH."post/".$oldFileName)) {
            rename(IMAGE_PATH."post/".$oldFileName, IMAGE_PATH."post/".$newFileName);
        }
    }
}
