<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Blog Model (Utility Class).
 *
 * This model is responsible for handling all database operations related to blog items.
 */
final class Blog
{
    /**
     * Returns single blog item with specified id.
     *
     * @param int $id The ID of the blog item.
     * @return array<string, mixed>|false Array with blog item information or false if not found.
     */
    public static function getBlogItemById(int $id): array|false
    {
        if ($id) {
            $db = \App\Core\Db::getConnection();

            $sql = 'SELECT * FROM blog WHERE id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
        return false;
    }

    /**
     * Returns an array of blog items.
     *
     * @return array<int, array{id: int, title: string, date: string, short_content: string}> Array of blog items.
     */
    public static function getBlogList(): array
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT id, title, date, short_content '
            . 'FROM blog '
            . 'ORDER BY date DESC '
            . 'LIMIT 3');

        $blogList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $blogList[$i] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'date' => $row['date'],
                'short_content' => $row['short_content']
            ];
            $i++;
        }

        return $blogList;
    }
}
