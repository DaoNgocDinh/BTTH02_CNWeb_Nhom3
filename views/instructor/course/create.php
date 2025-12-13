<?php
$title = 'Tạo Khóa Học Mới';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] < 1) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

require_once __DIR__ . '/../../../models/Category.php';
$categories = Category::getAll();
?>

<!-- MAIN WRAPPER -->
<main class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-8">

        <!-- HEADER -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">➕ Tạo Khóa Học Mới</h1>
            <p class="text-gray-600 mt-1 text-sm">Điền thông tin chi tiết để tạo khóa học</p>
        </div>

        <!-- FORM -->
        <form method="POST" action="<?= BASE_URL ?>/instructor/course/store" enctype="multipart/form-data" class="space-y-6">
            
            <!-- Tên Giáo Viên (Chọn) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    👨‍🏫 Giáo Viên <span class="text-red-500">*</span>
                </label>
                <select name="instructor_id" required
                        class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                    <option value="">-- Chọn giáo viên --</option>
                    <?php
                    require_once __DIR__ . '/../../../models/User.php';
                    require_once __DIR__ . '/../../../config/Database.php';
                    $db = Database::connect();
                    $stmt = $db->prepare("SELECT id, fullname FROM users WHERE role = 1 ORDER BY fullname");
                    $stmt->execute();
                    $instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($instructors as $instr): ?>
                        <option value="<?= $instr['id'] ?>"
                            <?= ($_SESSION['user']['id'] == $instr['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($instr['fullname']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tên Khóa Học -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    📌 Tên Khóa Học <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required maxlength="255" 
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
                    placeholder="Mô tả chi tiết về khóa học"></textarea>
            </div>

            <!-- Grid 2 cột -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thể Loại -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📂 Thể Loại <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                        class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                        <option value="">-- Chọn thể loại --</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?? '' ?>">
                                    <?= htmlspecialchars($cat['name'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Không có thể loại nào</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Giá -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        💰 Giá (VND) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" required min="0" value="0"
                        class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition"
                        placeholder="0">
                </div>

                <!-- Thời Gian -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        ⏱️ Thời Gian (Tuần) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="duration_weeks" required min="1" value="1"
                        class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition"
                        placeholder="1">
                </div>

                <!-- Mức Độ -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📊 Mức Độ <span class="text-red-500">*</span>
                    </label>
                    <select name="level" required
                        class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
                        <option value="Beginner">🟢 Cơ Bản</option>
                        <option value="Intermediate">🟡 Trung Cấp</option>
                        <option value="Advanced">🔴 Nâng Cao</option>
                    </select>
                </div>
            </div>

            <!-- Ảnh Khóa Học -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🖼️ Ảnh Khóa Học
                </label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-blue-300 outline-none transition">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between pt-4 border-t border-gray-200 gap-3">
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                    ✅ Tạo
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
