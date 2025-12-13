<?php
require_once __DIR__ ."/../config/Database.php";
class Material {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getByLesson($lesson_id) {
        $stmt = $this->db->prepare("SELECT * FROM materials WHERE lesson_id = ?");
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO materials
            (lesson_id, filename, file_path, file_type, uploaded_at)
            VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['lesson_id'],
            $data['file_name'],
            $data['file_path'],
            $data['file_type'],
            $data['created_at'] ?? date('Y-m-d H:i:s')
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM materials WHERE id = ?");
        return $stmt->execute([$id]);
    }
}