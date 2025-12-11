<?php
$title = 'Admin Dashboard';
require_once __DIR__ . '/../../views/layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<div class="courses-list">
    <?php if (!empty($fullCourses)): ?>
            <?php foreach ($fullCourses as $course): ?>
                   
                            <div class="course-card">
                            <h3><?= htmlspecialchars($course['title']) ?></h3>
                            <p>Thể loại: <?= htmlspecialchars($course['category_name'] ?? '') ?></p>
                            <p>Miêu tả thể loại: <?= htmlspecialchars($course['category_description'] ?? '') ?></p>
                            <p><?= nl2br(htmlspecialchars($course['course_description'] ?? '')) ?></p>
                            <p>Giá: <?= htmlspecialchars($course['price'] ?? '') ?></p>
                            <p>Thời lượng: <?= htmlspecialchars($course['duration_weeks'] ?? '') ?> giờ</p>
                            <p>Level: <?= htmlspecialchars($course['level'] ?? '') ?></p>

                            <?php $st = $course['status'] ?? null; ?>
                           
                            <?php if ($st === 'active'): ?>
                                    <div class="course-actions">
                                            <span style="color: green; font-weight: bold;">Đang học</span>
                                            <form method="POST" action="<?= BASE_URL ?>/my-courses" style="display:inline">
                                                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                                                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                                    <button type="submit" name="action" value="drop" class="btn small">Hủy môn học</button>
                                                    <button style="display: none;" type="submit" name="action" value="complete" class="btn small">Hoàn thành môn học</button>
                                                </form>
                                        </div>
                                <?php elseif ($st === 'dropper' || $st === 'dropped'): ?>
                                    <div class="course-actions">
                                            <span style="color: #a00; font-weight: bold;">Đã hủy</span>
                                            <form method="POST" action="<?= BASE_URL ?>/my-courses" style="display:inline">
                                                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                                                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                                    <button type="submit" name="action" value="reactivate" class="btn small">Tiếp tục học</button>
                                                </form>
                                        </div>
                                <?php elseif ($st === 'completed'): ?>
                                    <div class="course-actions">
                                            <span style="color: blue; font-weight: bold;">Hoàn thành</span>
                                        </div>
                                <?php endif; ?>

                        </div>        
                <?php endforeach; ?>
    <?php else: ?>
            <p>Bạn chưa đăng ký khóa học nào.</p>
    <?php endif; ?>
</div>
<style>
    .courses-list {
    display: flex;
    flex-wrap: wrap;    
    gap: 20px;           
    justify-content: flex-start;
    padding: 20px 0;
}

.course-card {
    flex: 1 1 calc(25% - 20px); 
    min-width: 250px;    
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.course-card .btn.small {
    padding: 5px 10px;
    margin: 5px 5px 0 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.course-card button[value="drop"] {
    background-color: #dc3545;
    color: white;
}

.course-card button[value="complete"] {
    background-color: #007bff;
    color: white;
}

.course-card button[value="reactivate"] {
    background-color: #28a745;
    color: white;
}

/* Responsive */
@media (max-width: 1200px) {
    .course-card {
        flex: 1 1 calc(33.33% - 20px);
    }
}

@media (max-width: 900px) {
    .course-card {
        flex: 1 1 calc(50% - 20px);
    }
}

@media (max-width: 600px) {
    .course-card {
        flex: 1 1 100%;
    }
}

</style>