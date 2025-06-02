<?php
session_start();

require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

// Get the 'url' parameter and sanitize it
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Determine controller name from first segment or default
$controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';

// Determine action name from second segment or default to 'index'
$action = isset($url[1]) && $url[1] !== '' ? $url[1] : 'index';

// Check if controller file exists
$controllerFile = 'app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    // Controller file not found
    die('Controller not found');
}

require_once $controllerFile;

// Instantiate controller
if (!class_exists($controllerName)) {
    die('Controller class not found');
}
$controller = new $controllerName();

// Check if action method exists in controller
if (!method_exists($controller, $action)) {
    die('Action not found');
}

// Call the action method with any additional URL segments as parameters
$params = array_slice($url, 2);
call_user_func_array([$controller, $action], $params);
