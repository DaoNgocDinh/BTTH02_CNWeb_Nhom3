<h2><?= htmlspecialchars($lesson->title) ?></h2>

<p><?= nl2br(htmlspecialchars($lesson->content)) ?></p>

<h3>📎 Tài liệu</h3>

<?php if ($materials): ?>
    <ul>
        <?php foreach ($materials as $m): ?>
            <li>
                <a href="<?= BASE_URL ?>/<?= $m->file_path ?>" target="_blank">
                    <?= htmlspecialchars($m->file_name) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Chưa có tài liệu</p>
<?php endif; ?>
