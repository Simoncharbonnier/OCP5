<?php

class Home {

  /**
   * Display the home page
   */
  public function index() : void {
    include_once('app/views/home/index.php');
  }

  /**
   * Send a mail and redirect to the home page
   */
  public function mail() : void {
    try {
      if ((isset($_POST['first_name']) && !empty($_POST['first_name'])) && (isset($_POST['last_name']) && !empty($_POST['last_name'])) && (isset($_POST['mail']) && !empty($_POST['mail'])) && (isset($_POST['message']) && !empty($_POST['message']))) {
        $to = 'simoncharbonnier@orange.fr';
        $subject = 'Blog contact';

        $message = file_get_contents('app/views/mail/index.html');
        $replace = ['first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'],
                          'mail' => $_POST['mail'], 'messageHere' => $_POST['message']];
        foreach ($replace as $string => $value) {
          $message = str_replace($string, $value, $message);
        }

        $headers = [
          'MIME-Version: 1.0',
          'Content-type:text/html;charset=UTF-8'
        ];

        mail($to, $subject, $message, implode("\r\n", $headers));

        header("Location: http://localhost/P5/?controller=home&action=index&success=success_mail_sent");
        exit;
      } else {
        throw new Exception("missing_param");
      }
    } catch(Exception $e) {
      header("Location: http://localhost/P5/?controller=home&action=index&error=" . $e->getMessage());
      exit;
    }
  }
}
