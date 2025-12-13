<?php
require_once 'models/Lesson.php';
require_once 'models/Material.php';
require_once 'models/Course.php';
require_once 'models/Enrollment.php';


class LessonController
{
    private $lessonModel;
    private $materialModel;
    private $courseModel;
    private $enrollmentModel;


    public function __construct()
    {

        $this->lessonModel   = new Lesson();
        $this->materialModel = new Material();
        $this->courseModel   = new Course();
        $this->enrollmentModel = new Enrollment();
    }

    // Quản lý bài học của 1 khóa học
    public function index($courseId)
    {
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
    public function update($lesson_id)
    {
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
    public function delete($lesson_id)
    {
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
    public function upload($lessonId)
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] < 1) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $lesson = $this->lessonModel->find($lessonId);
        if (!$lesson) {
            $_SESSION['error'] = "Bài học không tồn tại!";
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            exit;
        }

        $course = $this->courseModel->find($lesson->course_id);
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại!";
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            exit;
        }

        if ($user['role'] == 1 && $course->instructor_id != $user['id']) {
            $_SESSION['error'] = "Bạn không có quyền upload!";
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
            $uploadDir = 'assets/uploads/lessons/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $uploadedFiles = [];
            $errors = [];

            // Xử lý multiple files
            foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
                if (!empty($tmpName) && $_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
                    $originalName = $_FILES['files']['name'][$key];
                    $fileName = time() . '_' . uniqid() . '_' . basename($originalName);
                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($tmpName, $filePath)) {
                        try {
                            // Lưu vào database
                            $result = $this->materialModel->create([
                                'lesson_id' => $lessonId,
                                'file_path' => $filePath,
                                'file_name' => $originalName,
                                'file_type' => pathinfo($filePath, PATHINFO_EXTENSION),
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            if ($result) {
                                $uploadedFiles[] = $originalName;
                            } else {
                                $errors[] = "Lỗi lưu DB: " . $originalName;
                            }
                        } catch (Exception $e) {
                            $errors[] = "Lỗi lưu: " . $originalName . " (" . $e->getMessage() . ")";
                        }
                    } else {
                        $errors[] = "Không thể upload: " . $originalName;
                    }
                } else if (!empty($tmpName)) {
                    $errors[] = "Lỗi file: " . $_FILES['files']['name'][$key];
                }
            }

            // Tạo message phù hợp
            if (!empty($uploadedFiles)) {
                $_SESSION['success'] = " Tải lên " . count($uploadedFiles) . " tệp thành công!";
            }
            if (!empty($errors)) {
                $_SESSION['error'] = " " . implode(", ", $errors);
            }
            if (empty($uploadedFiles) && empty($errors)) {
                $_SESSION['error'] = " Vui lòng chọn file để upload!";
            }

            header('Location: ' . BASE_URL . '/instructor/course/' . $course->id . '/lessons');
            exit;
        }

        // Nếu không phải POST, redirect
        header('Location: ' . BASE_URL . '/instructor/course/' . $course->id . '/lessons');
        exit;
    }

    public function learn($lessonId)
{
    $user = $_SESSION['user'] ?? null;
    if (!$user) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    $lesson = $this->lessonModel->find($lessonId);
    if (!$lesson) {
        die('Bài học không tồn tại');
    }

    $course = $this->courseModel->find($lesson->course_id);

    // ✅ chỉ chặn nếu là SINH VIÊN nhưng CHƯA đăng ký
    if ($user['role'] == 0) {
        require_once 'models/Enrollment.php';
        $enroll = new Enrollment();

        if (!$enroll->isEnrolled($user['id'], $course->id)) {
            die('Bạn chưa đăng ký khóa học này');
        }
    }

    $materials = $this->materialModel->getByLesson($lessonId);

    require 'views/student/lesson_detail.php';
}

    
}
