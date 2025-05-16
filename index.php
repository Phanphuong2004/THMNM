<?php

require_once 'app/models/ProductModel.php';

$url = $_GET["url"] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';

// Xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Kiểm tra xem controller có tồn tại không
if (!file_exists("app/controllers/" . $controllerName . ".php")) {
    // Xử lý không tìm thấy controller
    die('Controller not found');
}

require_once 'app/controllers/' . $controllerName . '.php';

// Tạo instance của controller
$controller = new $controllerName();

// Kiểm tra xem action có tồn tại trong controller không
if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
?>