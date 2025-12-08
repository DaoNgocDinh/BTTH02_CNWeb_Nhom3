<?php
require_once __DIR__ . '/../models/User.php';

class AdminController {

    public function profile() {
        if (!isset($_SESSION['user'])) {
            die("Không tìm thấy thông tin user từ token!");
        }

        $userId = $_SESSION['user']['id'];
        $user = User::findById($userId);

        require_once __DIR__ . '/../views/profile.php';
    }
}
