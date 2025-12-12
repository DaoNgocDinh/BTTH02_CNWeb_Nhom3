<form action="<?= BASE_URL ?>/instructor/lesson/store/<?= $course->id ?>" method="POST">
    <label>Tiêu đề:</label>
    <input type="text" name="title" required>

    <label>Nội dung:</label>
    <textarea name="content"></textarea>

    <label>Video URL:</label>
    <input type="text" name="video_url">

    <label>Thứ tự:</label>
    <input type="number" name="order" value="1">

    <button type="submit">Thêm bài học</button>
</form>
