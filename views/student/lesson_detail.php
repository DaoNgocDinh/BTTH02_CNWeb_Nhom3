<?php
$title = "Online Course";
require_once __DIR__ . '/../layouts/header.php';
$courses = $courses ?? [];
$enrollmentStatusMap = $enrollmentStatusMap ?? [];
?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>
<div class="lesson-content-container">
    <h2><?= htmlspecialchars($lesson->title) ?></h2>

    <p><?= nl2br(htmlspecialchars($lesson->content)) ?></p>
    <a href="<?= htmlspecialchars($lesson->video_url) ?>" target="_blank"
           class="text-blue-600 hover:text-blue-800 underline">
            <?= htmlspecialchars($lesson->video_url) ?>
        </a>
    <h3>📎 Tài liệu</h3>

    <?php if ($materials): ?>
        <ul class="materials-list">
            <?php foreach ($materials as $material): ?>
                <li class="materials-list-item">
                    <a href="<?= BASE_URL . '/' . $material->file_path ?>" target="_blank">
                        <?= htmlspecialchars($material->filename) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="no-material">Chưa có tài liệu</p>
    <?php endif; ?>
</div>?>
<style>
    body {
        background-color: #f7f7f7;
        color: #333;
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        padding: 20px;
    }

    .lesson-content-container {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        margin-bottom: 20px;
    }
    h2 {
        color: #1a1a1a;
        border-bottom: 2px solid #ccc;
        padding-bottom: 15px;
        margin-bottom: 25px;
        font-weight: 700;
        margin-top: 0;
    }

    h3 {
        color: #444;
        margin-top: 40px;
        /* Tăng lề trên */
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 1.3em;
    }

    p {
        margin-bottom: 25px;
        color: #555;
    }
    ul.materials-list {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    li.materials-list-item {
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s;
    }

    .materials-list-item:hover {
        background-color: #f0f0f0;
        border-color: #b0b0b0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .materials-list-item a {
        display: block;
        padding: 15px 20px;
        text-decoration: none;
        color: #222;
        font-weight: 500;
        font-size: 1.05em;
        position: relative;
    }

    .materials-list-item a:hover {
        color: #000;
    }

    .materials-list-item a::before {
        content: "📎";
        margin-right: 10px;
        font-size: 1.2em;
        vertical-align: middle;
        color: #444;
    }
    p.no-material {
        font-style: italic;
        color: #888;
        padding: 15px 0;
    }
</style>