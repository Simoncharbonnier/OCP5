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

include_once('app/views/layout/index.php');
