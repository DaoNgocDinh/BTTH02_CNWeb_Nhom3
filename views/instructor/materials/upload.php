<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Material.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] < 1) {
    header("Location: /login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files']) && isset($_POST['lesson_id'])) {
    $lesson_id = $_POST['lesson_id'];
    $materialModel = new Material();

    $uploadDir = __DIR__ . '/../assets/uploads/materials/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    foreach ($_FILES['files']['error'] as $key => $error) {
        if ($error == 0) {
            $filename = time() . '_' . $_FILES['files']['name'][$key];
            $filepath = $uploadDir . $filename;
            $filetype = pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $filepath)) {
                $materialModel->create([
                    'lesson_id' => $lesson_id,
                    'filename'  => $_FILES['files']['name'][$key],
                    'file_path' => '/assets/uploads/materials/' . $filename,
                    'file_type' => $filetype
                ]);
            }
        }
    }

    $_SESSION['success'] = "Upload tài liệu thành công!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
