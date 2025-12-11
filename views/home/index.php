<?php
$title = "Online Course";
require_once __DIR__ . '/../layouts/header.php';

// `$courses` and optional `$enrollmentStatusMap` are provided by `HomeController`
$courses = $courses ?? [];
$enrollmentStatusMap = $enrollmentStatusMap ?? [];
?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
<section class="hero">
    <h1>Học lập trình Online 2TĐ</h1>
    <p>Khởi đầu sự nghiệp IT ngay hôm nay 🚀</p>

    <input
        id="search"
        type="search"
        placeholder="Bạn muốn học gì hôm nay?"
        onkeyup="filterCourses(this.value)"
    />
</section>

<!-- COURSE LIST -->
<section class="home-courses">
    <h2>Khoá học nổi bật</h2>
    <div class="course-grid" id="courseGrid">
        <?php foreach($courses as $c): ?>
            <div class="course-card" data-title="<?= strtolower($c['title']) ?>">
                
                <!-- Ảnh khóa học -->
                <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= $c['image'] ?>" alt="">
                
                <h3><?= htmlspecialchars($c['title']) ?></h3>
                <small><?= htmlspecialchars($c['level']) ?></small>
                <p class="price">$<?= htmlspecialchars($c['price']) ?></p>

                <div class="course-actions">

                    <?php 
                        $st = $enrollmentStatusMap[$c['id']] ?? null;
                    ?>

                    <!-- Trạng thái học -->
                    <?php if ($st): ?>
                        
                        <?php if ($st === 'active'): ?>
                            <span style="color: green; font-weight: bold;">✓ Đang học</span>

                        <?php elseif ($st === 'completed'): ?>
                            <span style="color: blue; font-weight: bold;">★ Hoàn thành</span>

                        <?php elseif ($st === 'dropper' || $st === 'dropped'): ?>
                            <span style="color: #a00; font-weight: bold;">✕ Đã hủy</span>

                        <?php endif; ?>
                    
                    <?php else: ?>
                        <!-- Nút đăng ký -->
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                            <button type="submit" name="action" value="register" class="btn small">
                                Đăng ký học môn
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- Nút xem chi tiết -->
                    <a href="<?= BASE_URL ?>/courses/<?= $c['id'] ?>" class="btn small">
                        Xem chi tiết
                    </a>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
function filterCourses(keyword){
    keyword = keyword.toLowerCase();

    document.querySelectorAll('.course-card').forEach(card=>{
        card.style.display =
            card.dataset.title.includes(keyword) ? "block" : "none";
    })
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
