<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController {
    private $userId;
    public $enrolled;
    public $enrollmentStatusMap;
    public $showEnrollmentList = false;

    public function __construct($userId) {
        $this->userId = $userId;
        $this->loadEnrollment();
        $this->handlePost();
    }

    private function loadEnrollment() {
        $this->enrolled = Enrollment::getEnrollmentByUserID($this->userId);
        $this->enrollmentStatusMap = [];
        foreach ($this->enrolled as $en) {
            $this->enrollmentStatusMap[$en['course_id']] = $en['status'] ?? 'active';
        }
    }

    private function handlePost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['action']) && isset($_POST['course_id'])) {
                $action = $_POST['action'];
                $courseId = $_POST['course_id'];

                if ($action === 'complete') {
                    Enrollment::updateActiveToCompleted($this->userId, $courseId);
                } elseif ($action === 'drop') {
                    Enrollment::dropCourse($this->userId, $courseId);
                } elseif ($action === 'register') {
                    Enrollment::activeCourses($this->userId, $courseId);
                } elseif ($action === 'active') {
                    Enrollment::updateDropToActive($this->userId, $courseId);
                }

                $this->loadEnrollment();
            }

            if (isset($_POST['enrollment_id'])) {
                $this->showEnrollmentList = true;
                $this->loadEnrollment();
            }

            if (!empty($_POST) && !isset($_POST['enrollment_id']) && !isset($_POST['action'])) {
                $this->showEnrollmentList = false;
            }
        }
    }
}

$userId = 2;
$enrollmentController = new EnrollmentController($userId);