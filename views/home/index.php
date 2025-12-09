<?php
$title = 'Trang chủ';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Chào mừng đến với MyApp</h1>
            <p class="text-lg text-gray-600">Nền tảng học tập trực tuyến hàng đầu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-blue-600">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Khóa học đa dạng</h3>
                <p class="text-gray-600">Hàng ngàn khóa học từ cơ bản đến nâng cao</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-green-600">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Giảng viên uy tín</h3>
                <p class="text-gray-600">Những chuyên gia hàng đầu trong lĩnh vực</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-purple-600">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Chứng chỉ hoàn thành</h3>
                <p class="text-gray-600">Nhận chứng chỉ khi hoàn thành khóa học</p>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Sẵn sàng bắt đầu?</h2>
            <a href="index.php?action=courses" class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                Khám phá khóa học
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
