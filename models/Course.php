<?php
require_once __DIR__ ."/../config/Database.php";
class Course {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }
    public function getAll($instructor_id = null) {
        if ($instructor_id) {
            $stmt = $this->db->prepare("SELECT c.*, cat.name as category_name
                                        FROM courses c
                                        JOIN categories cat ON c.category_id = cat.id
                                        WHERE c.instructor_id = ?
                                        ORDER BY c.created_at");
            $stmt->execute([$instructor_id]);
        } else {
            $stmt = $this->db->prepare("SELECT c.*, u.fullname as instructor_name, cat.name as category_name
                                        FROM courses c
                                        JOIN users u ON c.instructor_id = u.id
                                        JOIN categories cat ON c.category_id = cat.id
                                        ORDER BY c.created_at");
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data, $image_name) {
        $stmt = $this->db->prepare("INSERT INTO courses
            (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['instructor_id'],
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $image_name
        ]);
    }

    public function update($id, $data, $image_name = null) {
        if ($image_name) {
            $stmt = $this->db->prepare("UPDATE courses SET
                title=?, description=?, category_id=?, price=?, duration_weeks=?, level=?, image=?, updated_at=NOW()
                WHERE id=?");
            return $stmt->execute([
                $data['title'], $data['description'], $data['category_id'],
                $data['price'], $data['duration_weeks'], $data['level'],
                $image_name, $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE courses SET
                title=?, description=?, category_id=?, price=?, duration_weeks=?, level=?, updated_at=NOW()
                WHERE id=?");
            return $stmt->execute([
                $data['title'], $data['description'], $data['category_id'],
                $data['price'], $data['duration_weeks'], $data['level'], $id
            ]);
        }
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getByInstructor($instructor_id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE instructor_id = ?");
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
