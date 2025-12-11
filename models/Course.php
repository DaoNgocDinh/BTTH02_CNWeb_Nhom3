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

    public static function getCoursesByUserId($userId) {
        $pdo = Database::connect();

        try {
            $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $role = $stmt->fetchColumn();

            if ($role === false) {
                return [];
            }

            if ($role == 2) {
                $sql = "SELECT * FROM courses";
                return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            }

            if ($role == 1) {
                $sql = "SELECT * FROM courses WHERE instructor_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$userId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }


            if ($role == 0) {
                $sql = "SELECT c.* 
                        FROM courses c
                        JOIN enrollments e ON c.id = e.course_id
                        WHERE e.student_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$userId]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return [];

        } catch (PDOException $e) {
            return [];
        }
    }

    public static function getInfoCourseByCID($courseId) {
        $pdo = Database::connect();

        try {
        $sql = "SELECT 
            courses.id,
            courses.title,
            courses.description AS course_description,
            courses.price,
            courses.duration_weeks,
            courses.level,
            categories.name AS category_name,
            categories.description AS category_description
        FROM courses
        JOIN categories ON courses.category_id = categories.id
        WHERE courses.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$courseId]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function searchCourse($criteria) {
        $pdo = Database::connect();

        try {
            if (is_array($criteria)) {
                $sql = "SELECT c.* FROM courses c WHERE 1=1";
                $params = [];

                if (!empty($criteria['ten_khoa_hoc'])) {
                    $sql .= " AND c.title LIKE ?";
                    $params[] = '%' . $criteria['ten_khoa_hoc'] . '%';
                }

                if (!empty($criteria['id'])) {
                    $sql .= " AND c.id = ?";
                    $params[] = $criteria['id'];
                }

                if (!empty($criteria['level'])) {
                    $sql .= " AND c.level = ?";
                    $params[] = $criteria['level'];
                }

                if (!empty($criteria['category'])) {
                    $sql .= " AND c.category_id = ?";
                    $params[] = $criteria['category'];
                }

                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $sql = "SELECT * FROM courses WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$criteria]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return is_array($criteria) ? [] : null;
        }
    }

}
