<?php

class Router
{
    private $routes = [];

    public function get($path, $handler)
    {
        $this->add('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->add('POST', $path, $handler);
    }

    private function add($method, $path, $handler)
    {
        // Convert {id} to (\d+) for numeric IDs
        $regex = preg_replace('/\{id\}/', '(\\d+)', $path);
        // Convert other {param} to ([^/]+)
        $regex = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $regex);

        if($regex[0] !== '/') {
            $regex = '/' . $regex;
        }
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => '#^' . $regex . '$#',
            'handler' => $handler,
            'path' => $path
        ];
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // remove full match

                [$controllerClass, $action] = $route['handler'];

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        // Pass route parameters to controller action
                        $controller->$action(...$matches);
                        return;
                    }
                }
            }
        }

        $this->handleNotFound();
    }

    private function handleNotFound()
    {
        http_response_code(404);
        echo '<h1>404 - Trang không tồn tại</h1>';
    }
}
