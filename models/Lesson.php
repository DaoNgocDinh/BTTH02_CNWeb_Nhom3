<?php

class Lesson
{
    private static $table = 'lessons';

    public static function getAll()
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' ORDER BY `order` ASC';
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

    public static function getByCourse($course_id)
    {
        $db = \Database::connect();
        $query = 'SELECT * FROM ' . self::$table . ' WHERE course_id = ? ORDER BY `order` ASC';
        $stmt = $db->prepare($query);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = \Database::connect();
        $query = 'INSERT INTO ' . self::$table . ' (course_id, title, content, video_url, `order`) VALUES (?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['course_id'] ?? null,
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['video_url'] ?? null,
            $data['order'] ?? 0
        ]);
    }

    public static function update($id, $data)
    {
        $db = \Database::connect();
        $query = 'UPDATE ' . self::$table . ' SET course_id = ?, title = ?, content = ?, video_url = ?, `order` = ? WHERE id = ?';
        $stmt = $db->prepare($query);
        return $stmt->execute([
            $data['course_id'] ?? null,
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['video_url'] ?? null,
            $data['order'] ?? 0,
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
