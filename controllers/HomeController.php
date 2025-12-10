<?php

class HomeController
{
    public function index()
    {
        // If user is admin (role 2), redirect to admin dashboard
        if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && (int)$_SESSION['user']['role'] === 2) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }

        // If user is logged in but not admin, show courses
        if (isset($_SESSION['user'])) {
            // try {
            //     $courses = \Course::getAll();
            //     require_once __DIR__ . '/../views/courses/index.php';
            //     exit;
            // } catch (Exception $e) {

            // }
               require_once __DIR__ . '/../views/home/index.php';
                exit;
        }

        // Not logged in - show welcome page
        require_once __DIR__ . '/../views/home/index.php';
    }
}
