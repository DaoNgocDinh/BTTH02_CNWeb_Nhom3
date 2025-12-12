<?php foreach ($courses as $course): ?>
    <div class="course-card">
        <h3><?= htmlspecialchars($course['title']) ?></h3>
        <p>Thể loại: <?= htmlspecialchars($course['category_name']) ?></p>
        <p>Thời lượng: <?= htmlspecialchars($course['duration_weeks']) ?> tuần</p>

        <a href="<?= BASE_URL ?>/instructor/my-courses?course_id=<?= $course['id'] ?>" class="btn btn-primary">
            Xem chi tiết
        </a>
    </div>
<?php endforeach; ?>
