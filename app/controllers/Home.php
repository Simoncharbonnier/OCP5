<?php

class Home {

  /**
   * Display the home page
   */
  public function index() : void {
    include_once('app/views/home/index.php');
  }

  /**
   * Send a mail
   */
  public function mail() : void {
    try {
      if ((isset($_POST['first_name']) && !empty($_POST['first_name'])) && (isset($_POST['last_name']) && !empty($_POST['last_name'])) && (isset($_POST['mail']) && !empty($_POST['mail'])) && (isset($_POST['message']) && !empty($_POST['message']))) {
        $header = "De la part de " . $_POST['last_name'] . " " . $_POST['first_name'] . " :";
        $body = "<br>" . $_POST['message'] . "<br>";
        $footer = "Tu peux lui répondre à cette adresse : " . $_POST['mail'];

        $message = $header . $body . $footer;
        $result = mail('simoncharbonnier@orange.fr', 'BLOG CONTACT', $message);
        var_dump($result);
      } else {
        throw new Exception("Il manque une ou plusieurs informations.");
      }
    } catch(Exception $e) {
      $message = $e->getMessage();
    }
  }
}
