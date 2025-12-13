<?php
$title = htmlspecialchars($course['title'] ?? '');
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="course-detail-container">
    <a href="<?= BASE_URL ?>/" class="back-btn">← Quay về trang chủ</a>

    <h1><?= htmlspecialchars($course['title'] ?? '') ?></h1>

    <p class="description">
        <?= nl2br(htmlspecialchars($course['description'] ?? 'Không có mô tả')) ?>
    </p>

    <div class="info">
        <p><strong>Thể loại:</strong> <?= htmlspecialchars($course['category_name'] ?? '-') ?></p>
        <p><strong>Miêu tả thể loại:</strong> <?= htmlspecialchars($course['category_description'] ?? '-') ?></p>
        <p><strong>Giá:</strong>
            <?= !empty($course['price']) ? '$' . number_format($course['price'], 2) : 'Free' ?>
        </p>
        <p><strong>Thời lượng:</strong> <?= htmlspecialchars($course['duration_weeks'] ?? '-') ?> tuần</p>
        <p><strong>Level:</strong> <?= htmlspecialchars($course['level'] ?? '-') ?></p>
        <p><strong>Course ID:</strong> <?= htmlspecialchars($course['id'] ?? '-') ?></p>
    </div>

    <a href="<?= BASE_URL ?>/my-courses" class="enroll-btn">Đăng ký học</a>
</div>

<style>
.course-detail-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 30px 25px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.course-detail-container a.back-btn {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 20px;
    transition: color 0.3s ease;
}

.course-detail-container a.back-btn:hover {
    color: #0056b3;
}

.course-detail-container h1 {
    font-size: 2.2rem;
    margin-bottom: 10px;
    color: #222;
}

.course-detail-container p.description {
    color: #555;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.course-detail-container .info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 20px;
    margin-bottom: 25px;
}

.course-detail-container .info p {
    background: #f1f3f5;
    padding: 12px 15px;
    border-radius: 8px;
    margin: 0;
    font-size: 0.95rem;
}

.course-detail-container .info p strong {
    color: #333;
}

.course-detail-container .enroll-btn {
    display: inline-block;
    padding: 12px 25px;
    background: #007bff;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.3s ease;
}

.course-detail-container .enroll-btn:hover {
    background: #0056b3;
}

/* Responsive */
@media (max-width: 600px) {
    .course-detail-container .info {
        grid-template-columns: 1fr;
    }
}
</style>
