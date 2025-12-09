<?php

class Course
{
    private static $table = 'courses';

    public static function getAll()
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' ORDER BY created_at DESC';
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

    public static function getByInstructor($instructor_id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE instructor_id = ? ORDER BY created_at DESC';
        $stmt = $db->prepare($query);
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByCategory($category_id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE category_id = ? ORDER BY created_at DESC';
        $stmt = $db->prepare($query);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = \Database::connect();
        $query = 'INSERT INTO ' . self::$table . ' (title, description, instructor_id, category_id, price, duration_weeks, level, image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['instructor_id'] ?? null,
            $data['category_id'] ?? null,
            $data['price'] ?? 0,
            $data['duration_weeks'] ?? null,
            $data['level'] ?? 'Beginner',
            $data['image'] ?? null
        ]);
    }

    public static function update($id, $data)
    {
        $db = \Database::connect();
        $query = 'UPDATE ' . self::$table . ' SET title = ?, description = ?, category_id = ?, price = ?, duration_weeks = ?, level = ?, image = ? WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['category_id'] ?? null,
            $data['price'] ?? 0,
            $data['duration_weeks'] ?? null,
            $data['level'] ?? 'Beginner',
            $data['image'] ?? null,
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
