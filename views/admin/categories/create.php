<?php require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';?>

<div class="container mt-4">
    <h1 class="mb-4">Thêm thể loại mới</h1>

    <form action="<?= BASE_URL ?>/admin/categories" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Tên thể loại:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-secondary">Hủy</a>
    </form>
</div>