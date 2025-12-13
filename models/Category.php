<?php
require_once __DIR__ . '/../config/Database.php';

class Category
{
    private static $table = 'categories';

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
        $query = 'INSERT INTO ' . self::$table . ' (name, description) VALUES (?, ?)';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['description'] ?? null
        ]);
    }

    public static function update($id, $data)
    {
        $db = \Database::connect();
        $query = 'UPDATE ' . self::$table . ' SET name = ?, description = ? WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['name'] ?? null,
            $data['description'] ?? null,
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

    public static function getAllCategories() {
        $pdo = Database::connect();

        try {
            $sql = "SELECT * FROM categories";
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
