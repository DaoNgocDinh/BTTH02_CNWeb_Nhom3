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

    public static function create($data)
    {
        $db = \Database::connect();
        $query = 'INSERT INTO ' . self::$table . ' (name, description, category_id, instructor_id, price, created_at) 
                  VALUES (?, ?, ?, ?, ?, NOW())';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['category_id'] ?? null,
            $data['instructor_id'] ?? null,
            $data['price'] ?? 0
        ]);
    }

    public static function update($id, $data)
    {
        $db = \Database::connect();
        $query = 'UPDATE ' . self::$table . ' SET name = ?, description = ?, category_id = ?, price = ? WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['category_id'] ?? null,
            $data['price'] ?? 0,
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
