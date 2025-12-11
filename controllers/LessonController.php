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
    public function index($course_id)
    {
        $course = $this->courseModel->find($course_id);
        if (!$course || $course->instructor_id != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Không có quyền!";
            header('Location: /instructor/courses');
            exit;
        }

        $lessons = $this->lessonModel->getByCourse($course_id);
        require 'views/instructor/lessons/manage.php';
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
        header("Location: /instructor/course/$course_id/lessons");
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
    public function update($lesson_id)
    {
        $lesson = $this->lessonModel->find($lesson_id);
        $course = $this->courseModel->find($lesson->course_id);
        if (!$course || $course->instructor_id != $_SESSION['user']['id']) {
            die("Không có quyền!");
        }

        $data = [
            'title'     => trim($_POST['title']),
            'content'   => $_POST['content'] ?? '',
            'video_url' => $_POST['video_url'] ?? '',
            'order'     => $_POST['order'] ?? 999
        ];

        $this->lessonModel->update($lesson_id, $data);
        $_SESSION['success'] = "Cập nhật bài học thành công!";
        header("Location: /instructor/course/{$lesson->course_id}/lessons");
        exit;
    }

    // Xóa bài học
    public function delete($lesson_id)
    {
        $lesson = $this->lessonModel->find($lesson_id);
        if ($lesson) {
            $course = $this->courseModel->find($lesson->course_id);
                if ($course->instructor_id == $_SESSION['user']['id']) {
                $this->lessonModel->delete($lesson_id);
                $_SESSION['success'] = "Xóa bài học thành công!";
            }
        }
        header("Location: /instructor/course/{$lesson->course_id}/lessons");
        exit;
    }

    // Upload tài liệu cho bài học
    public function uploadMaterial($lesson_id)
    {
        $lesson = $this->lessonModel->find($lesson_id);
        if (!$lesson) die("Bài học không tồn tại!");

        $course = $this->courseModel->find($lesson->course_id);
        if ($course->instructor_id != $_SESSION['user']['id']) die("Không có quyền!");

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files']) && count($_FILES['files']['error']) > 0) {
            $uploadDir = 'assets/uploads/materials/';

            foreach ($_FILES['files']['error'] as $key => $error) {
                if ($error == 0) {
                    $filename = time() . '_' . $_FILES['files']['name'][$key];
                    $filepath = $uploadDir . $filename;
                    $filetype = pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);

                    if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $filepath)) {
                        $this->materialModel->create([
                            'lesson_id'  => $lesson_id,
                            'filename'   => $_FILES['files']['name'][$key],
                            'file_path'  => $filepath,
                            'file_type'  => $filetype
                        ]);
                    }
                }
            }
            $_SESSION['success'] = "Upload tài liệu thành công!";
        }

        header("Location: /instructor/course/{$lesson->course_id}/lessons");
        exit;
    }
}