<?php

// Start the session to manage user state across requests
session_start();

// Require necessary application files
// These models and controllers are used by the router for dispatching requests.
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/controllers/ProductApiController.php';
require_once 'app/controllers/CategoryApiController.php';

/**
 * Front Controller (Router)
 *
 * This script acts as the central entry point for all web requests.
 * It parses the URL, determines the appropriate controller and action
 * to execute, and dispatches the request accordingly. It handles both
 * standard web requests and API requests.
 */

// --- URL Parsing ---
// Get the URL path from the $_GET superglobal, defaulting to an empty string if not set.
$url = $_GET['url'] ?? '';

// Remove any trailing slashes to ensure consistent routing.
$url = rtrim($url, '/');

// Sanitize the URL to remove any illegal characters, improving security.
$url = filter_var($url, FILTER_SANITIZE_URL);

// Split the URL into an array of segments, based on the '/' delimiter.
$url_segments = explode('/', $url);

// Determine the controller name from the first segment of the URL.
// If the first segment is empty, or not set, default to 'DefaultController'.
$controllerName = !empty($url_segments[0]) ? ucfirst($url_segments[0]) . 'Controller' : 'ProductController';

// Determine the action (method) name from the second segment of the URL.
// If the second segment is empty, or not set, default to 'index'.
$action = !empty($url_segments[1]) ? $url_segments[1] : 'index';

// --- API Request Routing ---
// Check if the request is for the API, identified by 'api' as the first URL segment.
if ($controllerName === 'ApiController' && isset($url_segments[1])) {
    // Construct the API controller name (e.g., 'ProductApiController' for '/api/product').
    $apiControllerName = ucfirst($url_segments[1]) . 'ApiController';

    // Define the path to the API controller file.
    $apiControllerPath = 'app/controllers/' . $apiControllerName . '.php';

    // Check if the API controller file exists.
    if (file_exists($apiControllerPath)) {
        require_once $apiControllerPath; // Include the API controller file.
        $controller = new $apiControllerName(); // Instantiate the API controller.

        // Get the HTTP request method (GET, POST, PUT, DELETE).
        $method = $_SERVER['REQUEST_METHOD'];

        // Extract the ID from the URL (third segment), if present.
        // This ID is typically used for 'show', 'update', or 'destroy' actions.
        $id = $url_segments[2] ?? null;

        // Map HTTP methods to controller actions for API requests.
        switch ($method) {
            case 'GET':
                $action = ($id !== null) ? 'show' : 'index';
                break;
            case 'POST':
                $action = 'store';
                break;
            case 'PUT':
                $action = ($id !== null) ? 'update' : null; // 'update' requires an ID
                break;
            case 'DELETE':
                $action = ($id !== null) ? 'destroy' : null; // 'destroy' requires an ID
                break;
            default:
                // If an unsupported HTTP method is used, return a 405 Method Not Allowed response.
                http_response_code(405);
                echo json_encode(['message' => 'Phương thức HTTP không được phép.']);
                exit; // Terminate script execution.
        }

        // --- Start Fix for Deprecated Warning and better error handling ---
        // If $action is null here, it means a PUT or DELETE request was made without an ID.
        // This is an invalid API call for these methods.
        if ($action === null) {
            http_response_code(400); // 400 Bad Request
            echo json_encode(['message' => 'Thiếu ID cho hành động API này (PUT/DELETE cần ID).']);
            exit;
        }
        // --- End Fix ---

        // Validate if the determined action method exists in the API controller.
        if (method_exists($controller, $action)) {
            // Call the controller action, passing the ID if it's available.
            if ($id !== null) {
                call_user_func_array([$controller, $action], [(int)$id]); // Cast ID to integer.
            } else {
                call_user_func_array([$controller, $action], []);
            }
        } else {
            // If the action method does not exist, return a 404 Not Found response.
            http_response_code(404);
            echo json_encode(['message' => 'Hành động API không tìm thấy.']);
        }
        exit; // Terminate script execution after handling API request.
    } else {
        // If the API controller file does not exist, return a 404 Not Found response.
        http_response_code(404);
        echo json_encode(['message' => 'Bộ điều khiển API không tìm thấy.']);
        exit; // Terminate script execution.
    }
}

// --- Standard Web Request Routing ---
// Handle non-API requests (e.g., for rendering HTML pages).
$controllerPath = 'app/controllers/' . $controllerName . '.php';

// Check if the standard controller file exists.
if (file_exists($controllerPath)) {
    require_once $controllerPath; // Include the controller file.
    $controller = new $controllerName(); // Instantiate the controller.
} else {
    // If the controller is not found, terminate with an error message.
    // In a production environment, you might redirect to a 404 error page.
    die('Bộ điều khiển không tìm thấy.');
}

// Validate if the determined action method exists in the controller.
if (method_exists($controller, $action)) {
    // Call the controller action, passing any remaining URL segments as arguments.
    // array_slice($url_segments, 2) gets all segments starting from the third one.
    call_user_func_array([$controller, $action], array_slice($url_segments, 2));
} else {
    // If the action method does not exist, terminate with an error message.
    // In a production environment, you might redirect to a 404 error page.
    die('Hành động không tìm thấy.');
}
?>