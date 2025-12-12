<?php
$title = "Quản lý bài học: " . htmlspecialchars($course->title);
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';

?>

<style>
    main {
        padding: 20px;
        background-color: #f7f7f7;
        min-height: 100vh;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 24px;
        font-weight: bold;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .btn:hover {
        background-color: #218838;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f1f1f1;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    .action-link {
        margin-right: 10px;
        text-decoration: none;
        font-weight: bold;
    }

    .action-edit {
        color: #007bff;
    }

    .action-edit:hover {
        color: #0056b3;
    }

    .action-delete {
        color: #dc3545;
    }

    .action-delete:hover {
        color: #a71d2a;
    }

    .action-upload {
        color: #28a745;
    }

    .action-upload:hover {
        color: #1e7e34;
    }
</style>

<main>
    <div class="header">
        <h1>Quản lý bài học: <?= htmlspecialchars($course->title) ?></h1>
        <a href="<?= BASE_URL ?>/instructor/lesson/create/<?= $course->id ?>" class="btn">+ Thêm bài học</a>
    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($lessons)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Thứ tự</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?= $lesson->id ?></td>
                        <td><?= htmlspecialchars($lesson->title) ?></td>
                        <td><?= $lesson->order ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/instructor/lesson/edit/<?= $lesson->id ?>" class="action-link action-edit">Sửa</a>
                            <a href="<?= BASE_URL ?>/instructor/lesson/delete/<?= $lesson->id ?>" class="action-link action-delete" onclick="return confirm('Bạn có chắc muốn xóa bài học này?')">Xóa</a>
                            <form action="<?= BASE_URL ?>/instructor/lesson/upload" method="POST" enctype="multipart/form-data" class="inline-block">
                                <input type="hidden" name="lesson_id" value="<?= $lesson->id ?>">
                                <input type="file" name="files[]" multiple required>
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded">Upload</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có bài học nào. Thêm bài học mới ngay!</p>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>