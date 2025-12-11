<?php
$title = 'Admin Dashboard';
require_once __DIR__ . '/../../views/layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<h2>Tiến độ khóa học của tôi</h2>

<?php if (!empty($progressData)): ?>
    <div class="course-progress-list">
        <?php foreach ($progressData as $item): ?>
            <div class="course-progress-item">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="width: 100px; height: auto;">
                <strong><?= htmlspecialchars($item['title']) ?></strong>
                <p>Ngày đăng ký: <?= htmlspecialchars($enroll['enrolled_date'] ?? '') ?></p>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= htmlspecialchars($item['progress']) ?>%;"></div>
                </div>
                <span class="progress-percent"><?= htmlspecialchars($item['progress']) ?>%</span>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Bạn chưa đăng ký khóa học nào.</p>
<?php endif; ?>

<style>
.course-progress-list {
    max-width: 600px;
    margin: 20px auto;
    font-family: sans-serif;
}

.course-progress-item {
    margin-bottom: 20px;
}

.progress-bar {
    width: 100%;
    height: 20px;
    background-color: #e0e0e0; /* màu xám khi chưa lấp */
    border-radius: 10px;
    overflow: hidden;
    margin-top: 5px;
    position: relative;
}

.progress-fill {
    height: 100%;
    background-color: #4caf50; /* màu xanh khi lấp đầy */
    width: 0%;
    transition: width 0.5s ease-in-out;
}

.progress-percent {
    display: inline-block;
    margin-left: 10px;
    font-weight: bold;
}
</style>
