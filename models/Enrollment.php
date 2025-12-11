<?php

require_once __DIR__ . '/../config/Database.php';

class Enrollment
{
    private static $table = 'enrollments';

    public static function getAll()
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' ORDER BY enrolled_date DESC';
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByStudent($student_id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE student_id = ? ORDER BY enrolled_date DESC';
        $stmt = $db->prepare($query);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByCourse($course_id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE course_id = ? ORDER BY enrolled_date DESC';
        $stmt = $db->prepare($query);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = \Database::connect();
        $query = 'INSERT INTO ' . self::$table . ' (course_id, student_id, status, progress) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['course_id'] ?? null,
            $data['student_id'] ?? null,
            $data['status'] ?? 'enrolled',
            $data['progress'] ?? 0
        ]);
    }

    public static function update($id, $data)
    {
        $db = \Database::connect();
        $query = 'UPDATE ' . self::$table . ' SET status = ?, progress = ? WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['status'] ?? 'enrolled',
            $data['progress'] ?? 0,
            $id
        ]);
    }

    public static function delete($id)
    {
        $db = \Database::connect();
        $query = 'DELETE FROM ' . self::$table . ' WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([$id]);
    }
    public static function getEnrollmentByUserID($userId) {
        $pdo = Database::connect();

        try {
            $sql = "SELECT * FROM enrollments WHERE student_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function updateActiveToCompleted($userId, $courseId) {
        $pdo = Database::connect();

        try {
            $sql = "UPDATE enrollments 
                    SET status = 'completed', enrolled_date = NOW(), progress = 100
                    WHERE student_id = ? AND course_id = ? AND status = 'active'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId, $courseId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function dropCourse($userId, $courseId) {
        $pdo = Database::connect();

        try {
            $sql = "UPDATE enrollments 
                    SET status = 'dropped', enrolled_date = NOW() 
                    WHERE student_id = ? AND course_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId, $courseId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function activeCourses($userId, $courseId) {
        $pdo = Database::connect();

        try {
            $sql = "INSERT INTO enrollments ( course_id, student_id,  enrolled_date, status, progress) 
                    VALUES (?, ?, NOW(), 'active', 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$courseId, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function updateDropToActive($userId, $courseId) {
        $pdo = Database::connect();

        try {
            $sql = "UPDATE enrollments 
                    SET status = 'active', enrolled_date = NOW() 
                    WHERE student_id = ? AND course_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId, $courseId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getStatus($userId, $courseId) {
    $pdo = Database::connect();
    $sql = "SELECT status 
            FROM enrollments 
            WHERE student_id = ? AND course_id = ?
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $courseId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['status'] ?? null; // null nếu chưa đăng ký
}
}
