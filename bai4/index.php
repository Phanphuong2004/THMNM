<?php

session_start(); // Start the session at the very beginning

require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

// Get the URL and sanitize it
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Determine the controller name
// If the first part of the URL is empty, default to 'DefaultController'
$controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'ProductController';

// Determine the action name
// If the second part of the URL is empty, default to 'index'
$action = isset($url[1]) && $url[1] !== '' ? $url[1] : 'index';

// Debugging line (uncomment if needed)
// die ("controller=$controllerName - action=$action");

// Check if the controller file exists
$controllerPath = 'app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerPath)) {
    // Handle controller not found
    die('Controller not found');
}

// Include the controller file
require_once $controllerPath;

// Create an instance of the controller
$controller = new $controllerName();

// Check if the action method exists in the controller
if (!method_exists($controller, $action)) {
    // Handle action not found
    die('Action not found');
}

// Call the action method with remaining parameters (if any)
// array_slice($url, 2) gets all URL segments after the controller and action
call_user_func_array([$controller, $action], array_slice($url, 2));

?>