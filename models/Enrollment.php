<?php

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
}
