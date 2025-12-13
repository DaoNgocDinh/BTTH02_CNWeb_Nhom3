<?php
$title = "Quản lý bài học: " . htmlspecialchars($course->title);
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
?>

<main class="p-8 bg-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Quản lý bài học: <?= htmlspecialchars($course->title) ?></h1>
        <a href="<?= BASE_URL ?>/instructor/lesson/create/<?= $course->id ?>"
            class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            + Thêm bài học
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-400 rounded-lg">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($lessons)): ?>
        <div class="bg-white rounded-xl shadow overflow-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tiêu đề</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Thứ tự</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lessons as $lesson): ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600"><?= $lesson->id ?></td>
                            <td class="px-6 py-4 font-semibold text-gray-900"><?= htmlspecialchars($lesson->title) ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= $lesson->order ?></td>
                            <td class="px-6 py-4 flex gap-3 flex-wrap">
                                <a href="<?= BASE_URL ?>/instructor/lesson/edit/<?= $lesson->id ?>" class="text-blue-600 hover:underline">Sửa</a>
                                <a href="<?= BASE_URL ?>/instructor/lesson/delete/<?= $lesson->id ?>" class="text-red-600 hover:underline" onclick="return confirm('Bạn có chắc muốn xóa bài học này?')">Xóa</a>
                                <form action="<?= BASE_URL ?>/instructor/lesson/upload/<?= $lesson->id ?>"
      method="POST"
      enctype="multipart/form-data"
      style="display:inline">

    <input type="file" name="material" required>

    <button type="submit" class="btn btn-sm btn-primary">
        Tải tài liệu
    </button>
</form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="bg-white p-6 rounded-xl shadow text-center text-gray-600">
            <p class="text-lg">Chưa có bài học nào. Thêm bài học mới ngay!</p>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>