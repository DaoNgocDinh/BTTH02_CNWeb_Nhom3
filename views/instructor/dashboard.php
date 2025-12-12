<?php 
// Đảm bảo bạn đã liên kết file instructor_dashboard.css trong layout/header.php
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../layouts/sidebar.php'; 
?>

<div class="container mt-4">
    <h1 class="mb-4">Khóa học của tôi</h1>

    <?php if (!empty($coursesWithStudents)): ?>
        <div class="row">
            <?php foreach ($coursesWithStudents as $item):
                $course = $item['course'];
                $students = $item['students'];
                $imagePath = !empty($course->image) ? BASE_URL . '/assets/uploads/courses/' . $course->image : BASE_URL . '/assets/uploads/courses/default.jpg';
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4"> 
                    <div class="card h-100 shadow-sm">
                        <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($course->title) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($course->title) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($course->description) ?></p>
                            
                            <p><strong>Thể loại:</strong> <?= htmlspecialchars($course->category_id) ?></p>
                            <p><strong>Giá:</strong> <?= number_format($course->price) ?> VND</p>
                            <p><strong>Thời lượng:</strong> <?= $course->duration_weeks ?> tuần</p>
                            <p><strong>Level:</strong> <?= htmlspecialchars($course->level) ?></p>

                            <a href="<?= BASE_URL ?>/instructor/course/<?= $course->id ?>/lessons" class="btn btn-primary mt-auto">Xem bài học</a>

                            <div class="mt-3">
                                <h6>Học viên đăng ký (<?= count($students) ?>):</h6>
                                <?php if (!empty($students)): ?>
                                    <ul class="list-unstyled student-list-scroll">
                                        <?php foreach ($students as $s): ?>
                                            <li>• <?= htmlspecialchars($s['fullname'] ?? '') ?> (<?= htmlspecialchars($s['email'] ?? '') ?>)</li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Chưa có học viên nào đăng ký.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Chưa có khóa học nào.</p>
    <?php endif; ?>
</div>
<style>
    /* --- BASE STYLES & CONTAINER --- */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f0f0;
}

.container.mt-4 {
    padding-top: 30px;
    padding-bottom: 30px;
}

h1.mb-4 {
    margin-left: 5%;
    color: #333;
    width: fit-content;
    font-weight: 900;
    border-bottom: 2px solid #555;
    padding-bottom: 10px;
    margin-bottom: 30px !important;
}

/* --- CARD STYLING: WHITE TO DARK GRADIENT --- */
.card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s, box-shadow 0.3s;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    margin-left: 20%; /* Thêm margin trái để căn lề trái cho các card */
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

.card-img-top {
    width: 100%;          /* Chiều ngang đầy đủ */
    height: 150px;        /* Chiều cao bạn muốn */
    object-fit: cover;    /* Giữ tỉ lệ nhưng cắt phần thừa */
    display: block;       /* Tránh khoảng trắng thừa */
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.card-body {
    /* Áp dụng Gradient từ Trắng (trên) sang Đen (dưới) */
    background: linear-gradient(180deg, #ffffff 0%, #1a1a1a 100%); 
    color: #333; /* Màu chữ mặc định cho phần sáng */
    padding: 18px; /* Giảm padding bên trong */
    display: flex;
    flex-direction: column;
}

/* Điều chỉnh màu chữ cho phần tối (nửa dưới của card) */
.card-title {
    font-size: 1.1em; /* Giảm kích thước tiêu đề */
    font-weight: 700;
    color: #000000;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; 
}

.card-body p, .card-body h6 {
    font-size: 0.9em; /* Giảm kích thước chữ */
    margin-bottom: 4px;
}

/* Các thông tin nằm gần cuối (chứa danh sách học viên) */
.card-body .mt-3 {
    margin-top: 10px !important; 
    padding-top: 10px;
    border-top: 1px dashed rgba(255, 255, 255, 0.4); /* Đường kẻ trắng mờ */
}

/* Màu chữ trắng cho phần nội dung phía dưới của card (nơi gradient đậm) */
.card-body .mt-3 h6, 
.card-body .mt-3 p, 
.card-body .mt-3 ul, 
.card-body .mt-3 li {
    color: #ffffff; 
}

.col-lg-3{
    max-width: 25%;
}

/* Màu chữ đặc biệt cho các nhãn (Strong tag) */
.card-body p strong {
    color: #ffcc00; /* Màu vàng nổi bật trên nền tối */
}

/* --- STUDENT LIST SCROLLBAR --- */
.student-list-scroll {
    max-height: 100px !important; /* Giảm chiều cao tối đa của danh sách SV */
    overflow-y: auto;
    padding-left: 0;
}

.student-list-scroll::-webkit-scrollbar {
    width: 6px;
}

.student-list-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.4); 
    border-radius: 3px;
}

/* --- BUTTON STYLING --- */
.btn-primary {
    display: inline-block;
    padding: 8px 15px; /* Giảm padding nút bấm */
    font-size: 0.9em;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s, transform 0.1s;
    box-shadow: 0 2px 4px rgba(0, 123, 255, 0.4);
}

.btn-primary:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.6);
}
</style>