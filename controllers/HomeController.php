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
        // Load courses for homepage (public). If user logged in, also load enrollment status.
        require_once __DIR__ . '/../models/Course.php';
        require_once __DIR__ . '/../models/Enrollment.php';
        require_once __DIR__ . '/../models/User.php';

        $courseModel = new Course();
        $coursesRaw = $courseModel->getAll(); // returns array of objects
        $courses = [];
        foreach ($coursesRaw as $c) {
            // normalize to associative array for views
            $courses[] = (array) $c;
        }

        $enrollmentStatusMap = [];
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $enrolled = Enrollment::getEnrollmentByUserID($userId);
            foreach ($enrolled as $e) {
                $enrollmentStatusMap[$e['course_id']] = $e['status'] ?? 'active';
            }
        }

        require_once __DIR__ . '/../views/home/index.php';
    }
}
