<?php

require_once 'app/controllers/Controller.php';
require_once 'app/controllers/Comment.php';
require_once 'app/controllers/Post.php';

require_once 'app/models/User_Model.php';
require_once 'app/models/Comment_Model.php';
require_once 'app/models/Post_Model.php';

class User extends Controller
{

    /**
     * Add a user and redirect to the login page
     *
     * @return void
     * @throws Exception
     */

    public function signup() : void
    {
        try {
            if (empty($_POST) === FALSE && (isset($_POST['first_name']) === TRUE && empty($_POST['first_name']) === FALSE) && (isset($_POST['last_name']) === TRUE && empty($_POST['last_name']) === FALSE) && (isset($_POST['mail']) === TRUE && empty($_POST['mail']) === FALSE) && (isset($_POST['password']) === TRUE && empty($_POST['password']) === FALSE)) {
                if (isset($_POST['confirm']) === TRUE && $_POST['password'] === $_POST['confirm']) {
                    unset($_POST['confirm']);
                    $userModel = new User_Model();
                    $user = $userModel->getByMail($_POST['mail']);

                    if (empty($user) === TRUE) {
                        $passwordHash = password_hash($_POST['password'], CRYPT_BLOWFISH);
                        $datas = [];
                        foreach ($_POST as $name => $value) {
                            $datas[$name] = $value;
                        }
                        $datas['password'] = $passwordHash;

                        $userModel->create($datas);
                        header("Location: ".PATH."?controller=user&action=login&form=login&success=success_user_add");
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
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=user&action=login&form=signup&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Verify the credentials and redirect to the home page
     *
     * @return void
     * @throws Exception
     */

    public function login() : void
    {
        try {
            $this->isNotLogged();

            if (isset($_POST['mail']) === TRUE && isset($_POST['password']) === TRUE) {
                if (empty($_POST['mail']) === FALSE && empty($_POST['password']) === FALSE) {
                    $userModel = new User_Model();
                    $user = $userModel->getByMail($_POST['mail']);

                    if (empty($user) === FALSE) {
                        $user = $user[0];
                        $passwordHash = $user['password'];
                        if (password_verify($_POST['password'], $passwordHash) === TRUE) {
                            $_SESSION['is_logged'] = true;
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_mail'] = $user['mail'];
                            $_SESSION['user_avatar'] = $user['avatar'];
                            $_SESSION['user_admin'] = $user['admin'];
                            header("Location: ".PATH."?controller=home&action=index");
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
                include_once 'app/views/user/login.php';
            }
        } catch (Exception $e) {
            if ($e->getMessage() === 'no_perms_logged') {
                header("Location: ".PATH."?controller=home&action=index&error=no_perms");
            } else {
                header("Location: ".PATH."?controller=user&action=login&form=login&error=".$e->getMessage());
            }
            exit;
        }
    }

    /**
     * Logout a user and redirect to the home page
     *
     * @return void
     * @throws Exception
     */

    public function logout() : void
    {
        try {
            $this->isLogged();
            session_unset();
            session_destroy();
            header("Location: ".PATH."?controller=home&action=index");
            exit;
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Retrieve all users and display the list of users as an admin
     *
     * @return void
     * @throws Exception
     */

    public function index() : void
    {
        try {
            $this->isAdmin();

            $userModel = new User_Model();
            $users = $userModel->getAll();

            if (empty($users) === TRUE) {
                throw new Exception("no_users");
            }

            include_once 'app/views/user/index.php';
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Retrieve a user by its id and display user detail
     *
     * @return void
     * @throws Exception
     */

    public function detail() : void
    {
        try {
            if (isset($_GET['id']) === TRUE) {
                $userModel = new User_Model();
                $result = $userModel->getById($_GET['id'], true);

                if (empty($result) === FALSE) {
                    $user = $result[0];

                    if ($user['admin'] === 1) {
                        $postModel = new Post_Model();
                        $posts = $postModel->getByUser($user['id']);
                    }

                    $commentModel = new Comment_Model();
                    $result = $commentModel->getByUser($user['id']);
                    $comments = [];
                    foreach ($result as $comment) {
                        if ($comment['valid'] === 1) {
                            $postModel = new Post_Model();
                            $post = $postModel->getById($comment['post_id'])[0];
                            $comment['post_title'] = $post['title'];
                            $comment['post_id'] = $post['id'];
                            $comments[] = $comment;
                        }
                    }

                    include_once 'app/views/user/detail.php';
                } else {
                    throw new Exception("no_user");
                }
            } else {
                throw new Exception("inval");
            }
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Update a user by its id and redirect to user detail as the user himself
     *
     * @return void
     * @throws Exception
     */

    public function edit() : void
    {
        try {
            $this->isLogged();

            if (isset($_GET['id']) === true) {
                $userModel = new User_Model();
                $user = $userModel->getById($_GET['id']);
                if (empty($user) === false) {
                    $user = $user[0];

                    if ($_SESSION['user_mail'] === $user['mail']) {
                        if (empty($_POST) === FALSE && (isset($_POST['first_name']) === TRUE && empty($_POST['first_name']) === FALSE) && (isset($_POST['last_name']) === TRUE && empty($_POST['last_name']) === FALSE) && (isset($_POST['password']) === TRUE && empty($_POST['password']) === FALSE) && (isset($_POST['confirm']) === TRUE && empty($_POST['confirm']) === FALSE) && (isset($_POST['avatar']) === TRUE && empty($_POST['avatar']) === FALSE)) {
                            if ($_POST['password'] === $_POST['confirm']) {
                                unset($_POST['confirm']);

                                foreach ($_POST as $name => $value) {
                                    if ($name !== 'admin') {
                                        $datas[$name] = $value;
                                    }
                                }
                                $passwordHash = password_hash($_POST['password'], CRYPT_BLOWFISH);
                                $datas['password'] = $passwordHash;
                                $datas['id'] = $user['id'];

                                if ($_POST['avatar'] !== $user['avatar']) {
                                    if ($_POST['avatar'] !== 'default.jpg') {
                                        $allowed = [
                                                    'image/png',
                                                    'image/jpeg'
                                                   ];
                                        $type = $_FILES['image']['type'];
                                        if (in_array($type, $allowed) === TRUE) {
                                            $currentPath = $_FILES['image']['tmp_name'];
                                            $datas['avatar'] = $this->uploadAvatar($currentPath, 'user_'.$user['id'].'.jpg');
                                        }
                                    } else {
                                        $this->deleteAvatar($user['avatar']);
                                    }
                                }

                                $userModel->update($datas);

                                $_SESSION['user_avatar'] = $datas['avatar'];

                                header("Location: ".PATH."?controller=user&action=detail&id=".$user['id']."&success=success_user_edit");
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
        } catch (Exception $e) {
            if (isset($_GET['id']) === TRUE) {
                header("Location: ".PATH."?controller=user&action=detail&id=".$_GET['id']."&error=".$e->getMessage());
            } else {
                header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            }
            exit;
        }
    }

    /**
     * Delete a user by its id and redirect to users index as an admin
     *
     * @return void
     * @throws Exception
     */

    public function delete() : void
    {
        try {
            if (isset($_GET['id']) === TRUE) {
                $userModel = new User_Model();
                $result = $userModel->getById($_GET['id']);

                if (empty($result) === FALSE) {
                    $user = $result[0];
                    if ($_SESSION['is_logged'] === true && ($_SESSION['user_admin'] === 1 || $_SESSION['user_mail'] === $user['mail'])) {
                        if ($user['admin'] === 0) {
                            $commentModel = new Comment_Model();
                            $comments = $commentModel->getByUser($_GET['id']);

                            foreach ($comments as $comment) {
                                $commentModel->delete($comment['id']);
                            }

                            $postModel = new Post_Model();
                            $posts = $postModel->getByUser($_GET['id']);

                            foreach ($posts as $post) {
                                $postModel->delete($post['id']);
                                if (empty($post['image']) === FALSE) {
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

                            header("Location: ".PATH."?controller=user&action=index&success=success_user_delete");
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
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=user&action=index&error=".$e->getMessage());
            exit;
        }
    }

    /**
     * Upload user avatar and return filename
     * @param string $currentPath current path
     * @param string $newFileName new filename
     *
     * @return string
     */

    private function uploadAvatar($currentPath, $newFileName) : string
    {
        $newPath = IMAGE_PATH."user/".$newFileName;

        if (move_uploaded_file($currentPath, $newPath) === TRUE) {
            return $newFileName;
        }

        return 'default.jpg';
    }

    /**
     * Delete user avatar
     * @param string $fileName filename
     *
     * @return void
     */

    private function deleteAvatar($fileName) : void
    {
        $path = IMAGE_PATH."user/".$fileName;

        if (file_exists($path) === TRUE) {
            unlink($path);
        }
    }


    /**
     * Delete post image
     * @param string $fileName filename
     *
     * @return void
     */

    private function deleteImage($fileName) : void
    {
        $path = IMAGE_PATH."post/".$fileName;

        if (file_exists($path) === TRUE) {
            unlink($path);
        }
    }
}
