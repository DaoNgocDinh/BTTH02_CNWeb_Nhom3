<?php

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    // Đăng ký route GET
    public function get($path, $action)
    {
        $this->routes['GET'][$path] = $action;
    }

    // Đăng ký route POST
    public function post($path, $action)
    {
        $this->routes['POST'][$path] = $action;
    }

    // Hàm chạy router
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Chuẩn hóa lại path (loại bỏ /BTTH02 nếu có)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if (strpos($path, $scriptName) === 0) {
            $path = substr($path, strlen($scriptName));
        }

        if ($path === "") $path = "/";

        // Kiểm tra route có tồn tại không
        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "<h1>404 - Không tìm thấy đường dẫn</h1>";
            echo "Route: [$method] $path không tồn tại.";
            return;
        }

        // Lấy action từ định nghĩa Router
        $action = $this->routes[$method][$path];

        // Ví dụ: "AdminController@login"
        list($controllerName, $methodName) = explode("@", $action);

        $controllerFile = __DIR__ . "/../controllers/" . $controllerName . ".php";

        if (!file_exists($controllerFile)) {
            die("Không tìm thấy file controller: $controllerFile");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            die("Controller $controllerName không tồn tại.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            die("Method $methodName không tồn tại trong $controllerName.");
        }

        // Gọi controller method
        $controller->$methodName();
    }
}
