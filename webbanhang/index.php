<?php

// Lấy URL từ biến GET, nếu không có thì mặc định là chuỗi rỗng
$url = $_GET['url'] ?? ''; 

// Xóa dấu '/' ở cuối URL
$url = rtrim($url, '/'); 

// Lọc bỏ các ký tự không an toàn trong URL
$url = filter_var($url, FILTER_SANITIZE_URL); 

// Chia URL thành các phần dựa trên dấu '/'
$url = explode('/', $url);

// ---

## Xử lý Controller

// Kiểm tra phần đầu tiên của URL để xác định controller
// Nếu tồn tại và không rỗng, chuyển chữ cái đầu thành chữ hoa và thêm 'Controller'
// Nếu không, mặc định là 'DefaultController'
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';

// Kiểm tra xem file controller có tồn tại không
if (!file_exists("app/controllers/" . $controllerName . ".php")) {
    // Xử lý khi không tìm thấy controller
    die('Controller not found');
}

// Yêu cầu file controller
require_once 'app/controllers/' . $controllerName . '.php';

// Tạo đối tượng controller
$controller = new $controllerName();

// ---

## Xử lý Action

// Kiểm tra phần thứ hai của URL để xác định action
// Nếu tồn tại và không rỗng, sử dụng giá trị đó
// Nếu không, mặc định là 'index'
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Kiểm tra xem phương thức (action) có tồn tại trong controller không
if (!method_exists($controller, $action)) {
    // Xử lý khi không tìm thấy action
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
// array_slice($url, 2) sẽ lấy tất cả các phần tử từ chỉ số 2 trở đi, 
// tức là các tham số truyền vào cho action.
call_user_func_array([$controller, $action], array_slice($url, 2));

?>