<form action="<?= BASE_URL ?>/instructor/lesson/update/<?= $lesson->id ?>" method="POST">
    <label>Tiêu đề:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($lesson->title) ?>">

    <label>Nội dung:</label>
    <textarea name="content"><?= htmlspecialchars($lesson->content) ?></textarea>

    <label>Video URL:</label>
    <input type="text" name="video_url" value="<?= htmlspecialchars($lesson->video_url) ?>">

    <label>Thứ tự:</label>
    <input type="number" name="order" value="<?= $lesson->order ?>">

    <button type="submit">Cập nhật</button>
</form>
