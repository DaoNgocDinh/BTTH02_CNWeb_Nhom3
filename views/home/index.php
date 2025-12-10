<?php
$title = "Online Course";
require_once __DIR__ . '/../layouts/header.php';

/* MOCK DATA */
$courses = [
    ['id'=>1,'title'=>'PHP Cơ Bản','level'=>'Beginner','price'=>99,'image'=>'php.jpg'],
    ['id'=>2,'title'=>'HTML CSS','level'=>'Beginner','price'=>49,'image'=>'html.jpg'],
    ['id'=>3,'title'=>'UI UX Design','level'=>'Intermediate','price'=>119,'image'=>'uiux.jpg'],
    ['id'=>4,'title'=>'Digital Marketing','level'=>'Beginner','price'=>79,'image'=>'marketing.jpg']
];
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
                <img src="/BTTH02_CNWeb_Nhom3/assets/uploads/courses/<?= $c['image'] ?>" alt="" />
                <h3><?= $c['title'] ?></h3>
                <small><?= $c['level'] ?></small>
                <p class="price">$<?= $c['price'] ?></p>
                <div class="course-actions">
                    <a href="/BTTH02_CNWeb_Nhom3/views/student/course_detail.php"
                    class="btn small">
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
