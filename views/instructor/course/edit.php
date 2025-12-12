<?php
$title = 'Chỉnh Sửa Khóa Học';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] < 1) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

require_once __DIR__ . '/../../../models/Category.php';
$categories = Category::getAll();

if (empty($course)) {
    echo '<div class="p-8"><div class="bg-red-100 p-4 rounded text-red-700">❌ Khóa học không tồn tại!</div></div>';
    require_once __DIR__ . '/../../layouts/footer.php';
    exit;
}
?>

<!-- MAIN WRAPPER -->
<main class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-8">

        <!-- HEADER -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">✏️ Chỉnh Sửa Khóa Học</h1>
            <p class="text-gray-600 mt-1 text-sm">Cập nhật thông tin khóa học</p>
        </div>

        <!-- FORM -->
        <form method="POST" action="<?= BASE_URL ?>/instructor/course/update/<?= $course->id ?>" 
              enctype="multipart/form-data" class="space-y-6">

            <!-- Tên Khóa Học -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    📌 Tên Khóa Học <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required maxlength="255" 
                       value="<?= htmlspecialchars($course->title ?? '') ?>"
                       class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition"
                       placeholder="Nhập tên khóa học">
            </div>

            <!-- Mô Tả -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    📝 Mô Tả <span class="text-red-500">*</span>
                </label>
                <textarea name="description" required rows="5"
                          class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition"
                          placeholder="Mô tả chi tiết"><?= htmlspecialchars($course->description ?? '') ?></textarea>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Thể Loại -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📂 Thể Loại <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                        <option value="">-- Chọn thể loại --</option>

                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= ($course->category_id == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Giá -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        💰 Giá (VND) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" required min="0"
                           value="<?= htmlspecialchars($course->price) ?>"
                           class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                </div>

                <!-- Thời gian -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        ⏱️ Thời Gian (Tuần) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="duration_weeks" required min="1"
                           value="<?= htmlspecialchars($course->duration_weeks) ?>"
                           class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                </div>

                <!-- Mức độ -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📊 Mức Độ <span class="text-red-500">*</span>
                    </label>
                    <select name="level" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                        <option value="Beginner" <?= $course->level === 'Beginner' ? 'selected' : '' ?>>🟢 Cơ Bản</option>
                        <option value="Intermediate" <?= $course->level === 'Intermediate' ? 'selected' : '' ?>>🟡 Trung Cấp</option>
                        <option value="Advanced" <?= $course->level === 'Advanced' ? 'selected' : '' ?>>🔴 Nâng Cao</option>
                    </select>
                </div>
            </div>

            <!-- Ảnh -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🖼️ Ảnh Khóa Học</label>

                <?php if (!empty($course->image) && $course->image !== 'default.jpg'): ?>
                    <div class="mb-3">
                        <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= htmlspecialchars($course->image) ?>" 
                             class="max-h-48 rounded-xl shadow">
                    </div>
                <?php endif; ?>

                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between pt-4 border-t border-gray-200 gap-3">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                    💾 Lưu
                </button>

                <a href="<?= BASE_URL ?>/instructor/course/manage"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                    ❌ Hủy
                </a>
            </div>

        </form>
    </div>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
