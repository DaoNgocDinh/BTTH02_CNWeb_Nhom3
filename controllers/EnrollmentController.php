<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController {
    private $userId;
    public $enrolled;
    public $enrollmentStatusMap;
    public $showEnrollmentList = false;

    public function __construct() {
        // Don't auto-redirect; some actions (like handleEnrollment) are public
        if (isset($_SESSION['user'])) {
            $this->userId = $_SESSION['user']['id'];
            $this->loadEnrollment();
        }
    }
    
    // Public route handler for enrollment POST from homepage
    public function handleEnrollment() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $courseId = $_POST['course_id'] ?? null;
        $action = $_POST['action'] ?? null;

        if ($courseId && $action) {
            if ($action === 'register') {
                Enrollment::activeCourses($userId, $courseId);
                $_SESSION['success'] = 'Đăng ký học môn thành công!';
            } elseif ($action === 'drop') {
                Enrollment::dropCourse($userId, $courseId);
                $_SESSION['success'] = 'Hủy học môn thành công!';
            } elseif ($action === 'complete') {
                Enrollment::updateActiveToCompleted($userId, $courseId);
                $_SESSION['success'] = 'Hoàn thành khóa học!';
            } elseif ($action === 'reactivate') {
                Enrollment::updateDropToActive($userId, $courseId);
                $_SESSION['success'] = 'Kích hoạt lại khóa học!';
            }
        }

        $redirect = $_POST['redirect'] ?? BASE_URL . '/my-courses';
        header('Location: ' . $redirect);
        exit;
    }

    private function loadEnrollment() {
        $this->enrolled = Enrollment::getEnrollmentByUserID($this->userId);
        $this->enrollmentStatusMap = [];
        foreach ($this->enrolled as $en) {
            $this->enrollmentStatusMap[$en['course_id']] = $en['status'] ?? 'active';
        }
    }

        public function courseProgress() {
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $userId = $_SESSION['user']['id'];

    // Lấy tất cả các khóa học người dùng đã đăng ký
    $enrollments = Enrollment::getEnrollmentByUserID($userId);

    $progressList = [];

    foreach ($enrollments as $enroll) {
        $courseId = $enroll['course_id'];

        // Lấy thông tin khóa học
        $course = Course::getInfoCourseByCID($courseId);

        // Tính progress theo thời gian
        $progress = Enrollment::getProgressByTime($userId, $courseId);

        $progressList[] = [
            'image' => $course['image'] ?? 'default.jpg',
            'title' => $course['title'] ?? 'Unknown',
            'enrolled_date' => $enroll['enrolled_date'] ?? '',
            'progress' => $progress
        ];
    }

    // Truyền dữ liệu sang view
    $progressData = $progressList;
    include_once 'views/student/course_progress.php';
}

}