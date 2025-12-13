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
    public function uploadMaterial($lessonId)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL);
        exit;
    }

    // 1. Lấy lesson
    $lesson = $this->lessonModel->find($lessonId);
    if (!$lesson) {
        die("Bài học không tồn tại");
    }

    $courseId = $lesson->course_id;

    // 2. Kiểm tra file
    if (!isset($_FILES['material']) || $_FILES['material']['error'] !== 0) {
        $_SESSION['error'] = "Upload thất bại!";
        header("Location: " . BASE_URL . "/instructor/course/$courseId/lessons");
        exit;
    }

    // 3. Lưu file
    $file = $_FILES['material'];
    $fileName = time() . '_' . basename($file['name']);
    $uploadDir = __DIR__ . '/../assets/uploads/materials/';
    $uploadPath = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $_SESSION['error'] = "Không thể lưu file!";
        header("Location: " . BASE_URL . "/instructor/course/$courseId/lessons");
        exit;
    }

    // 4. Lưu DB
    $this->materialModel->create([
        'lesson_id' => $lessonId,
        'file_name' => $fileName,
        'file_path' => 'assets/uploads/materials/' . $fileName
    ]);

    $_SESSION['success'] = "Tải tài liệu thành công!";

    // ✅ 5. QUAY VỀ TRANG QUẢN LÝ BÀI HỌC
    header("Location: " . BASE_URL . "/instructor/course/$courseId/lessons");
    exit;
}

public function learn($lessonId)
{
    $lesson = $this->lessonModel->find($lessonId);
    $materials = $this->materialModel->getByLesson($lessonId);

    require 'views/student/lesson_detail.php';
}


}
