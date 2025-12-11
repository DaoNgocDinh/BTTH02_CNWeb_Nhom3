<?php
$title = 'Admin Dashboard';
require_once __DIR__ . '/../../views/layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>
<?php if (!empty($fullCourses)): ?>
    <?php foreach ($fullCourses as $course): ?>
        <h3><?= htmlspecialchars($course['title']) ?></h3>
        <p>Thể loại: <?= htmlspecialchars($course['category_name'] ?? '') ?></p>
        <p>Miêu tả thể loại: <?= htmlspecialchars($course['category_description'] ?? '') ?></p>
        <p><?= nl2br(htmlspecialchars($course['course_description'] ?? '')) ?></p>
        <p>Giá: <?= htmlspecialchars($course['price'] ?? '') ?></p>
        <p>Thời lượng: <?= htmlspecialchars($course['duration_weeks'] ?? '') ?> giờ</p>
        <p>Level: <?= htmlspecialchars($course['level'] ?? '') ?></p>

        <?php $st = $course['status'] ?? null; ?>

        <?php if ($st === 'active'): ?>
            <span style="color: green; font-weight: bold;">Đang học</span>
            <form method="POST" action="<?= BASE_URL ?>/my-courses" style="display:inline">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit" name="action" value="drop" class="btn small">Hủy môn học</button>
                <button type="submit" name="action" value="complete" class="btn small">Hoàn thành môn học</button>
            </form>
        <?php elseif ($st === 'dropper' || $st === 'dropped'): ?>
            <span style="color: #a00; font-weight: bold;">Đã hủy</span>
            <form method="POST" action="<?= BASE_URL ?>/my-courses" style="display:inline">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit" name="action" value="reactivate" class="btn small">Tiếp tục học</button>
            </form>
        <?php elseif ($st === 'completed'): ?>
            <span style="color: blue; font-weight: bold;">Hoàn thành</span>
        <?php endif; ?>

        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Bạn chưa đăng ký khóa học nào.</p>
<?php endif; ?>
