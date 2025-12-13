<?php
$title = "Bài học khóa học";
require_once __DIR__ . '/../layouts/header.php';
$courses = $courses ?? [];
$enrollmentStatusMap = $enrollmentStatusMap ?? [];
?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="main-content">
        <h2><?= htmlspecialchars($course->title) ?></h2>

        <ul class="lesson-list">
            <?php foreach ($lessons as $lesson): ?>
                <li>
                    <a href="<?= BASE_URL ?>/learn/lesson/<?= $lesson->id ?>">
                        📘 <?= htmlspecialchars($lesson->title) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
</div>
<style>
.page-container {
    display: flex;
    min-height: 100vh;
}
.main-content {
    flex-grow: 1; 
    padding: 20px;
    max-width: 100%;
    box-sizing: border-box; 
}

body {
    background-color: #f4f4f4;
    color: #333;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

h2 {
    color: #1c1c1c;
    padding-bottom: 10px;
    border-bottom: 3px solid #131212ff;
    margin-top: 0;
    margin-bottom: 30px;
}
.lesson-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.lesson-list li {
    background: linear-gradient(135deg, #737375ff 0%, #080e22 100%);
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.lesson-list li:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
}

.lesson-list a {
    color: #ffffff;
    text-decoration: none;
    padding: 15px 20px;
    display: block;
    font-size: 1.1em;
    font-weight: 500;
    border-radius: 8px;
    transition: background-color 0.3s, color 0.3s;
    word-wrap: break-word; 
}
@media (max-width: 768px) {
    .page-container {
        flex-direction: column; 
    }
    .sidebar {
        width: 100%; 
        height: auto;
        padding: 10px 0;
    }
    .main-content {
        padding: 15px;
    }
    .lesson-list a {
        font-size: 1em;
    }
}
</style>