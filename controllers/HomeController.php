<?php

class HomeController
{
    public function index()
    {
        // If user is admin (role 0), redirect to admin dashboard
        if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && (int)$_SESSION['user']['role'] === 0) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }

        // If user is logged in but not admin, redirect to courses/dashboard
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        // Not logged in, redirect to login
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
