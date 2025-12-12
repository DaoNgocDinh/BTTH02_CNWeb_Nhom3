<?php
require_once __DIR__ . '/../models/User.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
    private $secret = "d8edd050d5510dfcd2d5fab82a3284ead31de8fc4ab6aa38b70b964b35969346552b89e3d948e312996d1d30744b701a9679535308bdf838ff9dc535057ee98dfd8c7b782f21980687872c36ba98af84";

    // ====== FORM ======
    public function showLogin() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        require __DIR__ . '/../views/auth/register.php';
    }

    // ====== REGISTER ======
    public function register() {
        $username = $_POST['username'];
        $email    = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $fullname = $_POST['fullname'];
        $role     = 0;

        // Save old input in session in case we need to redirect back
        $_SESSION['old'] = [
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email
        ];

        $ok = User::create($username, $email, $password, $fullname, $role);

        if ($ok) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đăng ký thành công. Đăng nhập để tiếp tục.'];
            // clear old input
            unset($_SESSION['old']);
            header('Location: ' . BASE_URL . '/login');
            exit;
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Đăng ký thất bại. Vui lòng thử lại.'];
            header('Location: ' . BASE_URL . '/register');
            exit;
        }
    }

    // ====== LOGIN ======
    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::findByEmail($email);

        // store email in old input so user doesn't need to retype
        $_SESSION['old'] = ['email' => $email];

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Sai tài khoản hoặc mật khẩu'];
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $payload = [
            "id" => $user["id"],
            "email" => $user["email"],
            "username" => $user["username"],
            "role" => $user["role"],
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $token = JWT::encode($payload, $this->secret, 'HS256');

        // Lưu token vào cookie (HTTP-only)
        setcookie("token", $token, time() + 3600, "/");

        // Lưu thông tin user vào session để kiểm tra truy cập phía server
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        // clear flash/old
        unset($_SESSION['flash']);
        unset($_SESSION['old']);

        // Đăng nhập xong chuyển hướng đến dashboard admin hoặc home
        if ($user['role'] == 2) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
        } else {
            header('Location: ' . BASE_URL . '/');
        }
        exit;
    }

    // ====== LOGOUT ======
    public function logout() {
        setcookie("token", "", time() - 3600, "/");
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
