<?php

require_once 'app/config/config.php';

if (isset($_GET['controller']) === TRUE && empty($_GET['controller']) === FALSE) {
    $controller = stripslashes($_GET['controller']);
} else {
    $controller = 'Home';
}

$controllerClassName = ucfirst($controller);
if (file_exists('app/controllers/'.$controllerClassName.'.php') === TRUE) {
    include_once 'app/controllers/'.$controllerClassName.'.php';
    $instance = new $controllerClassName();

    if (isset($_GET['action']) === TRUE && empty($_GET['action']) === FALSE) {
        $action = stripslashes($_GET['action']);
    } else {
        $action = 'index';
    }

    if (method_exists($instance, $action) === FALSE) {
        header("Location: ".PATH."?controller=home&action=index&error=inval");
        exit;
    }
} else {
    header("Location: ".PATH."?controller=home&action=index&error=inval");
    exit;
}

if (isset($_SESSION) === FALSE) {
    session_start();
    if (isset($_SESSION['is_logged']) === FALSE) {
        $_SESSION['is_logged'] = false;
    }
}

require_once 'app/views/layout/index.php';
