<?php

require_once 'app/controllers/Controller.php';

class Home extends Controller
{

    /**
     * Display the home page
     *
     * @return void
    */

    public function index() : void
    {
        include_once 'app/models/Post_model.php';
        $postModel = new Post_model();
        $posts = $postModel->get3Lasts();

        include_once 'app/views/home/index.php';
    }

    /**
     * Send a mail and redirect to the home page
     *
     * @return void
     * @throws
    */

    public function mail() : void
    {
        try {
            if ((isset($_POST['first_name']) === TRUE && empty($_POST['first_name']) === FALSE) && (isset($_POST['last_name']) === TRUE && empty($_POST['last_name']) === FALSE) && (isset($_POST['mail']) === TRUE && empty($_POST['mail']) === FALSE) && (isset($_POST['message']) === TRUE && empty($_POST['message']) === FALSE)) {
                $toMail = CONTACT_MAIL;
                $subject = 'Blog contact';

                $message = file_get_contents('app/views/mail/index.html');
                $replace = [
                            'first_name' => $_POST['first_name'],
                            'last_name' => $_POST['last_name'],
                            'mail' => $_POST['mail'],
                            'messageHere' => $_POST['message'],
                           ];

                foreach ($replace as $string => $value) {
                    $message = str_replace($string, $value, $message);
                }

                $headers = [
                            'MIME-Version: 1.0',
                            'Content-type:text/html;charset=UTF-8',
                           ];

                mail($toMail, $subject, $message, implode("\r\n", $headers));

                header("Location: ".PATH."?controller=home&action=index&success=success_mail_sent");
                exit;
            }

            throw new Exception("missing_param");
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }
}
