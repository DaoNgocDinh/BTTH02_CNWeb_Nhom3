<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
    public function show()
{
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    // LẤY LẠI USER TỪ DATABASE
    $user = User::findById($_SESSION['user']['id']);

    if (!$user) {
        die("Không tìm thấy người dùng");
    }

    require __DIR__ . '/../views/profile/info.php';
}

}
