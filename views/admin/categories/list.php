<?php require_once __DIR__ . '/../../layouts/header.php'; 
require_once __DIR__ . '/../../layouts/sidebar.php';?>

<div class="container mt-4">
    <h1>Quản lý thể loại</h1>

    <a href="<?= BASE_URL ?>/admin/categories/create" class="btn btn-primary mb-3">➕ Thêm thể loại</a>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success"><?= $_SESSION['flash'] ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên thể loại</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars($cat['description']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/categories/<?= $cat['id'] ?>/edit" class="btn btn-warning btn-sm">✏️ Sửa</a>
                        <a href="<?= BASE_URL ?>/admin/categories/<?= $cat['id'] ?>/delete" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">🗑️ Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
