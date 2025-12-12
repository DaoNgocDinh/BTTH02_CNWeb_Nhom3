<?php
$title = 'Quản lý Khóa Học';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';

// Kiểm tra quyền truy cập
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] < 1) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

require_once __DIR__ . '/../../../models/Course.php';
$courseModel = new Course();

$isAdmin = $_SESSION['user']['role'] == 2;
$isInstructor = $_SESSION['user']['role'] == 1;

// Lấy dữ liệu khóa học
$allCourses = $isAdmin ? $courseModel->getAll() : $courseModel->getByInstructor($_SESSION['user']['id']);
$courses = $allCourses;
?>

<main class="p-8 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Quản lý Khóa Học</h1>
        <?php if ($isAdmin): ?>
            <a href="<?= BASE_URL ?>/instructor/course/create"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-all">
                + Create Course
            </a>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($courses)): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-700">ID</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Tên Khóa Học</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Giảng Viên</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Giá</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Mức Độ</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Thời Gian</th>
                            <th class="px-6 py-4 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($courses as $course): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-600"><?= $course->id ?></td>
                                <td class="px-6 py-4 font-semibold text-gray-900"><?= htmlspecialchars($course->title) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($course->instructor_name ?? 'N/A') ?></td>
                                <td class="px-6 py-4 text-gray-900">₫<?= number_format($course->price, 0, '.', ',') ?></td>
                                <td class="px-6 py-4">
                                    <?php
                                        $levels = [
                                            'Beginner' => ['bg-green-100 text-green-700', '🟢 Cơ Bản'],
                                            'Intermediate' => ['bg-yellow-100 text-yellow-700', '🟡 Trung Cấp'],
                                            'Advanced' => ['bg-red-100 text-red-700', '🔴 Nâng Cao'],
                                        ];
                                        $l = $levels[$course->level] ?? ['bg-gray-100 text-gray-700', 'Unknown'];
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium <?= $l[0] ?>"><?= $l[1] ?></span>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?= $course->duration_weeks ?> tuần</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="<?= BASE_URL ?>/instructor/course/<?= $course->id ?>/lessons"
                                       class="text-blue-600 hover:text-blue-800 font-medium">Quản lý nội dung</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <div class="bg-white rounded-lg shadow-sm p-12 text-center border border-gray-200">
            <div class="text-6xl mb-4">📚</div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Không có khóa học nào</h2>
            <p class="text-gray-600 mb-6"><?php if ($isInstructor): ?>Bạn chưa có khóa học nào. Tạo ngay khóa học mới!<?php else: ?>Hệ thống chưa có khóa học nào.<?php endif; ?></p>
            <?php if ($isInstructor): ?>
                <a href="<?= BASE_URL ?>/instructor/course/create" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-lg">
                    + Create Course
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
