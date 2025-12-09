<?php

class Material
{
    private static $table = 'materials';

    public static function getAll()
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' ORDER BY uploaded_at DESC';
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

    public static function getByLesson($lesson_id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE lesson_id = ? ORDER BY uploaded_at DESC';
        $stmt = $db->prepare($query);
        $stmt->execute([$lesson_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = \Database::connect();
        $query = 'INSERT INTO ' . self::$table . ' (lesson_id, filename, file_path, file_type) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['lesson_id'] ?? null,
            $data['filename'] ?? null,
            $data['file_path'] ?? null,
            $data['file_type'] ?? null
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
