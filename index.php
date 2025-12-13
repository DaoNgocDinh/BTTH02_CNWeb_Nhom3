<?php
/**
 * Online Course Management System
 */
session_start();

// Define base path
define('BASE_PATH', __DIR__);
define('BASE_URL', '/' . basename(__DIR__));

// Enable verbose errors for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/vendor/autoload.php";  // Composer autoload
require_once __DIR__ . "/routers/routers.php";
require_once __DIR__ . "/config/Database.php";
require_once __DIR__ . "/models/Course.php";
require_once __DIR__ . "/controllers/AuthController.php";
require_once __DIR__ . "/controllers/AdminController.php";
require_once __DIR__ . "/controllers/HomeController.php";
require_once __DIR__ . "/controllers/CourseController.php";
require_once __DIR__ . "/controllers/LessonController.php";
require_once __DIR__ . "/controllers/EnrollmentController.php";
require_once __DIR__ . "/middleware/Auth_JWT.php";
require_once __DIR__ . "/controllers/ProfileController.php";


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = parse_url($requestUri, PHP_URL_PATH);

// Remove base path if it exists
if (strpos($requestUri, BASE_URL) === 0) {
    $requestUri = substr($requestUri, strlen(BASE_URL));
}

$requestUri = rtrim($requestUri, '/');
if (empty($requestUri)) {
    $requestUri = '/';
}

try {
    $router = new Router();

    // ====== HOME & PUBLIC ======
    $router->get('/', [HomeController::class, 'index']);

    // ====== AUTHENTICATION ======
    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/register', [AuthController::class, 'showRegister']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->get('/logout', [AuthController::class, 'logout']);
    $router->get('/profile/info', [ProfileController::class, 'info']);


    // ====== COURSES (PUBLIC & STUDENT) ======
    $router->get('/student/dashboard', [CourseController::class, 'studentDashboard']);
    $router->get('/instructor/dashboard', [CourseController::class, 'instructorDashboard']);

    $router->get('/my-courses', [CourseController::class, 'myCourses']);
    $router->get('/courses', [CourseController::class, 'browse']);
    $router->get('/courses/{id}', [CourseController::class, 'show']);
    $router->post('/my-courses', [EnrollmentController::class, 'handleEnrollment']);

    $router->get('/course-progress', [EnrollmentController::class, 'courseProgress']);
    $router->post('/my-courses', [EnrollmentController::class, 'handleEnrollment']);
    
    // ====== ENROLLMENT ======
    $router->post('/enroll', [EnrollmentController::class, 'handleEnrollment']);

    // ====== ADMIN ROUTES ======
    // Dashboard
    $router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
    $router->get('/admin/statistics', [AdminController::class, 'statistics']);

    // User Management
    $router->get('/admin/users', [AdminController::class, 'manageUsers']);
    $router->get('/admin/users/create', [AdminController::class, 'createUser']);
    $router->post('/admin/users', [AdminController::class, 'storeUser']);
    $router->get('/admin/users/{id}/edit', [AdminController::class, 'editUser']);
    $router->post('/admin/users/{id}', [AdminController::class, 'updateUser']);
    $router->get('/admin/users/{id}/delete', [AdminController::class, 'deleteUser']);

    // Category Management
    $router->get('/admin/categories', [AdminController::class, 'listCategories']);
    $router->get('/admin/categories/create', [AdminController::class, 'createCategory']);
    $router->post('/admin/categories', [AdminController::class, 'storeCategory']);
    $router->get('/admin/categories/{id}/edit', [AdminController::class, 'editCategory']);
    $router->post('/admin/categories/{id}', [AdminController::class, 'updateCategory']);
    
    //Course
    $router->get('/instructor/course/manage', [CourseController::class, 'manage']);
    $router->get('/instructor/courses', [CourseController::class, 'index']);
    $router->get('/instructor/course/create', [CourseController::class, 'create']);
    $router->post('/instructor/course/store', [CourseController::class, 'store']);
    $router->get('/instructor/course/edit/{id}', [CourseController::class, 'edit']);
    $router->post('/instructor/course/update/{id}', [CourseController::class, 'update']);
    $router->get('/instructor/course/delete/{id}', [CourseController::class, 'delete']);
    //Lesson Management
    $router->get('/instructor/lesson/manage', [LessonController::class, 'manage']);
    $router->get('/instructor/course/{id}/lessons', [LessonController::class, 'index']);
    $router->get('/instructor/lesson/create/{id}', [LessonController::class, 'create']);
    $router->post('/instructor/lesson/store/{id}', [LessonController::class, 'store']);
    $router->get('/instructor/lesson/edit/{id}', [LessonController::class, 'edit']);
    $router->post('/instructor/lesson/update/{id}', [LessonController::class, 'update']);
    $router->get('/instructor/lesson/delete/{id}', [LessonController::class, 'delete']);
    $router->post('/instructor/lesson/upload/{id}', [LessonController::class, 'uploadMaterial']);
    // Dispatch the request
    $router->dispatch($_SERVER['REQUEST_METHOD'], $requestUri);

} catch (Exception $e) {
    http_response_code(500);
    echo "<!DOCTYPE html><html lang=\"vi\"><head><title>500 - Server Error</title></head><body>";
    echo "<div style=\"text-align: center; padding: 50px;\">";
    echo "<h1>500 Internal Server Error</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<a href="/' . basename(__DIR__) . '/">Go to Homepage</a>';
    echo "</div></body></html>";
}

