<?php
require_once __DIR__ ."/../config/Database.php";
class Lesson {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getByCourse($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY `order` ASC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO lessons
            (course_id, title, content, video_url, `order`, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $data['course_id'],
            $data['title'],
            $data['content'],
            $data['video_url'],
            $data['order'] ?? 1
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE lessons SET title=?, content=?, video_url=?, `order`=? WHERE id=?");
        return $stmt->execute([
            $data['title'], $data['content'], $data['video_url'], $data['order'], $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM lessons WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function find($id) {
    $db = Database::connect();
    $stmt = $db->prepare("SELECT * FROM lessons WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

}