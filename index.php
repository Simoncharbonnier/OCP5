<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'app/config/config.php';

if (!empty($_GET['controller'])) {
	$controller = $_GET['controller'];
} else {
	$controller = 'Home';
}

$controllerClassName = ucfirst($controller);
if (file_exists('app/controllers/' . $controllerClassName . '.php')) {
	require_once 'app/controllers/' . $controllerClassName . '.php';
	$instance = new $controllerClassName();

	if (!empty($_GET['action'])) {
		$action = $_GET['action'];
	} else {
		$action = 'index';
	}

	if (!method_exists($instance, $action)) {
		header("Location: " . PATH . "?controller=home&action=index&error=inval");
		exit;
	}
} else {
	header("Location: " . PATH . "?controller=home&action=index&error=inval");
	exit;
}

if (!isset($_SESSION)) {
	session_start();
	if (!isset($_SESSION['is_logged'])) {
		$_SESSION['is_logged'] = false;
	}
}

include_once 'app/views/layout/index.php';
