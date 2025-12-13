<?php
require_once 'models/Lesson.php';
require_once 'models/Material.php';
require_once 'models/Course.php';


class LessonController
{
    private $lessonModel;
    private $materialModel;
    private $courseModel;

    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] < 1) {
            header('Location: /auth/login');
            exit;
        }

        $this->lessonModel   = new Lesson();
        $this->materialModel = new Material();
        $this->courseModel   = new Course();
    }

    // Quản lý bài học của 1 khóa học
     public function index($courseId) {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] < 1) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $course = $this->courseModel->find($courseId);

        // Kiểm tra quyền: instructor phải là chủ sở hữu hoặc admin
        if ($user['role'] == 1 && $course->instructor_id != $user['id']) {
            $_SESSION['error'] = "Bạn không có quyền truy cập khóa học này!";
            header('Location: ' . BASE_URL . '/instructor/course/manage');
            exit;
        }

        $lessons = $this->lessonModel->getByCourse($courseId);

        require_once __DIR__ . '/../views/instructor/lessons/manage.php';
    }

    

    // Form thêm bài học
    public function create($course_id)
    {
        $course = $this->courseModel->find($course_id);
        if (!$course || $course->instructor_id != $_SESSION['user']['id']) {
            die("Không có quyền!");
        }
        require 'views/instructor/lessons/create.php';
    }

    // Lưu bài học mới
    public function store($course_id)
    {
        $data = [
            'course_id'  => $course_id,
            'title'      => trim($_POST['title']),
            'content'    => $_POST['content'] ?? '',
            'video_url'  => $_POST['video_url'] ?? '',
            'order'      => $_POST['order'] ?? 999
        ];

        if ($this->lessonModel->create($data)) {
            $_SESSION['success'] = "Thêm bài học thành công!";
        }
        header("Location: " . BASE_URL . "/instructor/course/$course_id/lessons");
        exit;
    }

    // Form sửa bài học
    public function edit($lesson_id)
    {
        $lesson = $this->lessonModel->find($lesson_id);
        $course = $this->courseModel->find($lesson->course_id);

        if (!$course || $course->instructor_id != $_SESSION['user']['id']) {
            die("Không có quyền!");
        }

        require 'views/instructor/lessons/edit.php';
    }

    // Cập nhật bài học
    public function update($lesson_id) {
    $lesson = $this->lessonModel->find($lesson_id);
    if (!$lesson) die("Không có quyền!");

    $course_id = $lesson->course_id;

    $data = [
        'title'     => trim($_POST['title']),
        'content'   => $_POST['content'] ?? '',
        'video_url' => $_POST['video_url'] ?? '',
        'order'     => $_POST['order'] ?? 999
    ];

    if ($this->lessonModel->update($lesson_id, $data)) {
        $_SESSION['success'] = "Cập nhật bài học thành công!";
    } else {
        $_SESSION['error'] = "Cập nhật thất bại!";
    }

    // Quay về trang quản lý bài học cùng khóa
    header("Location: " . BASE_URL . "/instructor/course/$course_id/lessons");
    exit;
}


    // Xóa bài học
    public function delete($lesson_id) {
    $lesson = $this->lessonModel->find($lesson_id);
    if ($lesson) {
        $course_id = $lesson->course_id;
        $this->lessonModel->delete($lesson_id);
        $_SESSION['success'] = "Xóa bài học thành công!";
    }

    header("Location: " . BASE_URL . "/instructor/course/$course_id/lessons");
    exit;
}


    // Upload tài liệu cho bài học
     public function upload($lessonId) {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] < 1) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $lesson = $this->lessonModel->find($lessonId);
        $course = $this->courseModel->getById($lesson->course_id);

        if (!$lesson || ($user['role'] == 1 && $course->instructor_id != $user['id'])) {
            header('Location: ' . BASE_URL . '/403');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $uploadDir = 'assets/uploads/lessons/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $fileName = time() . '_' . basename($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $fileName);

            // TODO: Lưu đường dẫn file vào DB nếu cần

            header('Location: ' . BASE_URL . '/instructor/lesson/manage/' . $course->id);
            exit;
        }

        require 'views/instructor/lesson/upload.php';
    }
}
