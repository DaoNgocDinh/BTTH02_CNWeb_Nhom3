<?php
require_once 'models/User.php';
class ProfileController
{
    public function info()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $user = User::findById($userId);

        require 'views/profile/info.php';
    }
}
