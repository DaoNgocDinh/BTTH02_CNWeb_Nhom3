<?php

class CourseController
{
    // Display all courses
    public function index()
    {
        try {
            $courses = \Course::getAll();
            require_once __DIR__ . '/../views/courses/index.php';
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }

    // Display single course detail
    public function show($id)
    {
        try {
            $course = \Course::findById($id);
            if (!$course) {
                header('Location: ' . BASE_URL . '/courses');
                exit;
            }
            require_once __DIR__ . '/../views/courses/detail.php';
        } catch (Exception $e) {
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }
    }
}
