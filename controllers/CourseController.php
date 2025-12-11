<?php
require_once 'models/Course.php';
require_once 'models/Category.php';
require_once 'config/Database.php';

class CourseController
{
    private $courseModel;
    private $categoryModel;
    private $userId;
    public $courses;
    public $categories;
    public $detailCourse;

    public function __construct()
    {
        // Initialize models and common properties. Do NOT auto-redirect here;
        // public methods should work without an authenticated user.
        $this->courseModel = new Course();
        $this->categoryModel = new Category();

        $this->userId = $_SESSION['user']['id'] ?? null;
        $this->categories = Category::getAllCategories();
        $this->courses = [];
        $this->detailCourse = null;

        $this->handlePost();
    }

    // Danh sách khóa học của giảng viên
    public function index()
    {
        // Instructor-only listing
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] < 1) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $instructor_id = $_SESSION['user']['id'];
        $courses = $this->courseModel->getByInstructor($instructor_id);
        require 'views/instructor/my_courses.php';
    }

    // Public browse listing
    public function browse()
    {
        try {
            $courses = $this->courseModel->getAll();
        } catch (Exception $e) {
            $courses = [];
        }

        require 'views/courses/index.php';
    }

    // Public course detail
    public function show($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            http_response_code(404);
            echo "<h1>Course not found</h1>";
            return;
        }

        require 'views/courses/detail.php';
    }

    // Form tạo khóa học mới
    public function create()
    {
        $categories = $this->categoryModel->getAll();
        require 'views/instructor/course/create.php';
    }

    // Xử lý tạo khóa học
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /instructor/courses');
            exit;
        }

        $uploadDir = 'assets/uploads/courses/';
        $imageName = 'default.jpg'; // ảnh mặc định

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = time() . '_' . rand(1000, 9999) . '.' . $ext;
            $uploadFile = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $_SESSION['error'] = "Upload ảnh thất bại!";
                header('Location: /instructor/course/create');
                exit;
            }
        }

        $data = [
            'title'          => trim($_POST['title']),
            'description'    => $_POST['description'],
            'instructor_id'  => $_SESSION['user']['id'],
            'category_id'   => $_POST['category_id'],
            'price'          => $_POST['price'],
            'duration_weeks' => $_POST['duration_weeks'],
            'level'          => $_POST['level'],
            'image'          => $imageName
        ];

        if ($this->courseModel->create($data, $imageName)) {
            $_SESSION['success'] = "Tạo khóa học thành công!";
            header('Location: /instructor/courses');
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra!";
            header('Location: /instructor/course/create');
        }
        exit;
    }

    //chỉnh sửa
    public function edit($id)
    {
        $course = $this->courseModel->find($id);

        // Kiểm tra quyền sở hữu
        if (!$course || $course->instructor_id != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Không có quyền truy cập!";
            header('Location: /instructor/courses');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        require 'views/instructor/course/edit.php';
    }

    // Xử lý cập nhật
    public function update($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course || $course->instructor_id != $_SESSION['user']['id']) {
            die("Không có quyền!");
        }

        $imageName = $course->image;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            // Xóa ảnh cũ
            if ($imageName !== 'default.jpg' && file_exists("assets/uploads/courses/$imageName")) {
                unlink("assets/uploads/courses/$imageName");
            }

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = time() . '_' . rand(1000, 9999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "assets/uploads/courses/$imageName");
        }

        $data = [
            'title'          => trim($_POST['title']),
            'description'    => $_POST['description'],
            'category_id'    => $_POST['category_id'],
            'price'          => $_POST['price'],
            'duration_weeks' => $_POST['duration_weeks'],
            'level'          => $_POST['level'],
            'image'          => $imageName
        ];

        if ($this->courseModel->update($id, $data)) {
            $_SESSION['success'] = "Cập nhật thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại!";
        }
        header("Location: /instructor/course/edit/$id");
        exit;
    }

    // Xóa khóa học
    public function delete($id)
    {
        $course = $this->courseModel->find($id);
        if ($course && $course->instructor_id == $_SESSION['user']['id']) {
            // Xóa ảnh nếu không phải mặc định
            if ($course->image !== 'default.jpg' && file_exists("assets/uploads/courses/{$course->image}")) {
                unlink("assets/uploads/courses/{$course->image}");
            }
            $this->courseModel->delete($id);
            $_SESSION['success'] = "Xóa khóa học thành công!";
        }
        header('Location: /instructor/courses');
        exit;
    }
    private function handlePost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['search'])) {
                $filters = [
                    'ten_khoa_hoc' => $_POST['ten_khoa_hoc'] ?? '',
                    'id'           => $_POST['id'] ?? '',
                    'level'        => $_POST['level'] ?? '',
                    'category'     => $_POST['category'] ?? ''
                ];
                $this->courses = Course::searchCourse($filters);
            }

            if (isset($_POST['course_id'])) {
                $this->detailCourse = Course::getInfoCourseByCID($_POST['course_id']);
            }
        }
    }

    public function myCourses() {
    $userId = $_SESSION['user']['id'] ?? null;
    if (!$userId) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    $courses = Course::getCoursesByUserId($userId);

    $fullCourses = [];
    $enrollment = new Enrollment(); // tạo object Enrollment

    foreach ($courses as $c) {
        $courseInfo = Course::getInfoCourseByCID($c['id']);
        if ($courseInfo) {
            // Lấy status riêng cho user này
            $courseInfo['status'] = $enrollment->getStatus($userId, $c['id']);
            $fullCourses[] = $courseInfo;
        }
    }

    include_once 'views/student/my_courses.php';
}

    public function courseProgress() {
        include_once 'views/student/course_progress.php';
    }

}