<?php
$title = 'Admin Dashboard';
require_once __DIR__ . '/../../views/layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<div class="container">
    <h2>Tiến độ khóa học của tôi</h2>

    <?php if (!empty($progressData)): ?>
        <div class="course-progress-list">
            <?php foreach ($progressData as $item): 
                // Fix: Biến $enroll không tồn tại trong vòng lặp này. Tôi sẽ dùng ngày đăng ký mẫu.
                $enrollDate = $item['enrolled_date'] ?? 'N/A'; // Giả định Controller trả về enrolled_date
            ?>
                <div class="course-progress-item">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                    
                    <div style="flex-basis: 30%; position: relative; padding-right: 20px;">
                        <strong><?= htmlspecialchars($item['title']) ?></strong>
                        <p>Ngày đăng ký: <?= htmlspecialchars($enrollDate) ?></p>
                    </div>

                    <div class="progress-container-wrapper">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= htmlspecialchars($item['progress']) ?>%;"></div>
                        </div>
                        <span class="progress-percent"><?= htmlspecialchars($item['progress']) ?>%</span>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Bạn chưa đăng ký khóa học nào.</p>
    <?php endif; ?>
</div>

<style>
/* --- PROGRESS DASHBOARD STYLES --- */

/* Thiết lập font và nền */
body {
    background-color: #f8f9fa; /* Nền trắng xám nhẹ */
}

h2 {
    font-size: 1.8rem;
    color: #343a40;
    margin-bottom: 30px;
    border-bottom: 3px solid #050d14ff; /* Đường gạch chân màu xanh */
    padding-bottom: 8px;
    display: inline-block;
}

.course-progress-list {
    max-width: 800px; /* Tăng chiều rộng tối đa */
    margin: 20px 0; /* Căn lề trái */
    display: flex;
    flex-direction: column;
    gap: 20px; /* Khoảng cách giữa các item */
}

.course-progress-item {
    background: linear-gradient(90deg, #b8b5b5ff 0%, #343a40 100%);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 15px 25px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease;
}

.course-progress-item:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.course-progress-item img {
    width: 80px; /* Giảm kích thước ảnh */
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 20px;
    border: 2px solid #ced4da;
}

.course-progress-item strong {
    font-size: 1.2rem;
    color: #030f1bff; /* Tên khóa học màu xanh */
    flex-basis: 30%; /* Chiếm khoảng 30% diện tích */
    min-width: 150px;
    margin-bottom: 5px;
}

.course-progress-item p {
    position: absolute; 
    margin: 30px;
    font-size: 0.9rem;
    color: #010b13ff;
    left: 115px; 
    bottom: 25px;
}

/* --- PROGRESS BAR STYLING --- */
.progress-container-wrapper {
    flex-grow: 1; /* Cho phép phần tiến trình chiếm hết không gian còn lại */
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 20px;
}

.progress-bar {
    width: 100%;
    height: 10px; /* Thanh tiến trình mỏng hơn */
    background-color: #e9ecef; 
    border-radius: 5px;
    overflow: hidden;
    position: relative;
    margin-right: 15px;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(to right, #4CAF50, #8BC34A); /* Gradient xanh lá */
    border-radius: 5px;
    /* transition: width 0.5s ease-in-out; (giữ lại trong HTML) */
}

.progress-percent {
    font-size: 1.1rem;
    font-weight: bold;
    color: #4CAF50; /* Phần trăm màu xanh */
    width: 50px; /* Cố định chiều rộng để căn chỉnh */
    text-align: right;
}

/* --- Responsive Adjustments (Nếu cần thiết) --- */
@media (max-width: 768px) {
    .course-progress-item {
        flex-direction: column;
        align-items: flex-start;
    }
    .course-progress-item img {
        margin-bottom: 10px;
    }
    .course-progress-item strong {
        margin-bottom: 5px;
    }
    .progress-container-wrapper {
        width: 100%;
        padding-left: 0;
        margin-top: 10px;
    }
    .course-progress-item p {
        position: static;
        margin-left: 0;
    }
}
</style>
