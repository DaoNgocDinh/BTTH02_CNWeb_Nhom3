<?php
session_start();

require_once __DIR__ . "/vendor/autoload.php";  // Composer autoload

require_once __DIR__ . "/config/Database.php";
require_once __DIR__ . "/controllers/AuthController.php";
require_once __DIR__ . "/controllers/AdminController.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// ======================
//  MIDDLEWARE CHECK JWT
// ======================
function checkJWT() {
    if (!isset($_COOKIE['token'])) {
        return false;
    }

    $token = $_COOKIE['token'];
    $secret = "SECRET_KEY_ABC";

    try {
        $decoded = JWT::decode($token, new Key($secret, "HS256"));
        $_SESSION['user'] = (array)$decoded;   // Lưu user vào session
        return true;

    } catch (Exception $e) {
        return false;
    }
}

// ===============
//  ROUTING
// ===============

$action = $_GET['action'] ?? 'home';
$auth = new AuthController();
$adminController = new AdminController();

switch ($action) {

    // ====== AUTH ======
    case "login":
        $auth->showLogin();
        break;

    case "loginPost":
        $auth->login();
        break;

    case "register":
        $auth->showRegister();
        break;

    case "registerPost":
        $auth->register();
        break;

    case "logout":
        $auth->logout();
        break;

    // ====== USER PROFILE (có JWT) ======
    case "profile":
        if (!checkJWT()) {
            header("Location: index.php?action=login");
            exit;
        }
        $adminController->profile();
        break;

    // ====== HOME ======
    default:
        echo "<h1>Trang chủ</h1>";
        echo "<a href='index.php?action=login'>Đăng nhập</a> | ";
        echo "<a href='index.php?action=register'>Đăng ký</a>";
        break;
}
