<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!empty($_GET['controller'])) {
  $controller = $_GET['controller'];
} else {
  $controller = 'Home';
}

$controllerClassName = ucfirst($controller);
if (file_exists('app/controllers/' . $controllerClassName . '.php')) {
  require_once('app/controllers/' . $controllerClassName . '.php');
  $instance = new $controllerClassName();

  if (!empty($_GET['action'])) {
    $action = $_GET['action'];
  } else {
    $action = 'index';
  }

  if (!method_exists($instance, $action)) {
    require_once('app/controllers/Error.php');
    $instance = new ErrorClass();
    $action = 'error404';
  }
} else {
  require_once('app/controllers/Error.php');
  $instance = new ErrorClass();
  $action = 'error404';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/global.css">
  </head>
  <body>
    <?php include_once('app/views/components/header.php'); ?>
    <?php $instance->$action(); ?>
    <?php include_once('app/views/components/footer.php'); ?>
  </body>
</html>
