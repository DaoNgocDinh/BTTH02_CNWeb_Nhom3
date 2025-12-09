<?php
/**
 * Online Course Management System
 */
session_start();

// Define base path
define('BASE_PATH', __DIR__);
define('BASE_URL', '/BTTH02_CNWeb_Nhom3');

require_once __DIR__ . "/vendor/autoload.php";  // Composer autoload
require_once __DIR__ . "/routers/routers.php";
require_once __DIR__ . "/config/Database.php";
require_once __DIR__ . "/controllers/AuthController.php";
require_once __DIR__ . "/controllers/AdminController.php";
require_once __DIR__ . "/controllers/HomeController.php";
require_once __DIR__ . "/middleware/Auth_JWT.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = parse_url($requestUri, PHP_URL_PATH);

// Remove base path if it exists
if (strpos($requestUri, BASE_URL) === 0) {
    $requestUri = substr($requestUri, strlen(BASE_URL));
}

$requestUri = rtrim($requestUri, '/');
if (empty($requestUri)) {
    $requestUri = '/';
}

try {
    $router = new Router();

    // ====== HOME ======
    $router->get('/', [HomeController::class, 'index']);

    // ====== AUTH ======
    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/register', [AuthController::class, 'showRegister']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->get('/logout', [AuthController::class, 'logout']);

    // ====== ADMIN DASHBOARD & MANAGEMENT ======
    $router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
    $router->get('/admin/users', [AdminController::class, 'manageUsers']);
    $router->get('/admin/users/create', [AdminController::class, 'createUser']);
    $router->post('/admin/users', [AdminController::class, 'storeUser']);
    $router->get('/admin/users/{id}/edit', [AdminController::class, 'editUser']);
    $router->post('/admin/users/{id}', [AdminController::class, 'updateUser']);
    $router->get('/admin/users/{id}/delete', [AdminController::class, 'deleteUser']);

    // Admin Categories
    $router->get('/admin/categories', [AdminController::class, 'listCategories']);
    $router->get('/admin/categories/create', [AdminController::class, 'createCategory']);
    $router->post('/admin/categories', [AdminController::class, 'storeCategory']);
    $router->get('/admin/categories/{id}/edit', [AdminController::class, 'editCategory']);
    $router->post('/admin/categories/{id}', [AdminController::class, 'updateCategory']);

    $router->get('/admin/statistics', [AdminController::class, 'statistics']);

    // Dispatch
    $router->dispatch($_SERVER['REQUEST_METHOD'], $requestUri);

} catch (Exception $e) {
    http_response_code(500);
    echo "<!DOCTYPE html><html lang=\"vi\"><head><title>500 - Server Error</title></head><body>";
    echo "<div style=\"text-align: center; padding: 50px;\">";
    echo "<h1>500 Internal Server Error</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href=\"/BTTH02_CNWeb_Nhom3/\">Go to Homepage</a>";
    echo "</div></body></html>";
}

