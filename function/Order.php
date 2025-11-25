<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Class Order - model for working with orders
 */
final class Order
{
    /**
     * Saves a new order
     */
    public static function save(
        string $userName,
        string $userPhone,
        string $userComment,
        int|false $userId,
        array $products
    ): bool {
        // Database connection
        $db = Db::getConnection();

        // SQL query text
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
            . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';

        // Encode the products array into a JSON string for storage
        $productsJson = json_encode($products);

        $result = $db->prepare($sql);
        $result->bindValue(':user_name', $userName, PDO::PARAM_STR);
        $result->bindValue(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindValue(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindValue(':user_id', $userId !== false ? $userId : 0, PDO::PARAM_INT);
        $result->bindValue(':products', $productsJson, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Returns a list of all orders
     */
    public static function getOrdersList(): array
    {
        // Database connection
        $db = Db::getConnection();

        // Fetching and returning results
        $result = $db->query('SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC');
        $ordersList = [];

        while ($row = $result->fetch()) {
            $ordersList[] = [
                'id' => $row['id'],
                'user_name' => $row['user_name'],
                'user_phone' => $row['user_phone'],
                'date' => $row['date'],
                'status' => $row['status'],
            ];
        }

        return $ordersList;
    }

    /**
     * Returns a text explanation of the order status:
     * 1 - New order, 2 - Processing, 3 - Delivering, 4 - Closed
     */
    public static function getStatusText(int|string $status): string
    {
        return match ((string) $status) {
            '1' => 'New order',
            '2' => 'Processing',
            '3' => 'Delivering',
            '4' => 'Closed',
            default => 'Unknown',
        };
    }

    /**
     * Returns an order with the specified ID
     */
    public static function getOrderById(int $id): array|false
    {
        // Database connection
        $db = Db::getConnection();

        // SQL query text
        $sql = 'SELECT * FROM product_order WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);

        // Execute the query
        $result->execute();

        // Return the data
        return $result->fetch();
    }

    /**
     * Deletes an order with the given ID
     */
    public static function deleteOrderById(int $id): bool
    {
        // Database connection
        $db = Db::getConnection();

        // SQL query text
        $sql = 'DELETE FROM product_order WHERE id = :id';

        // Fetching and returning results. A prepared statement is used.
        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Edits an order with the given ID
     */
    public static function updateOrderById(
        int $id,
        string $userName,
        string $userPhone,
        string $userComment,
        string $date,
        int $status
    ): bool {
        // Database connection
        $db = Db::getConnection();

        // SQL query text
        $sql = "UPDATE product_order
            SET
                user_name = :user_name,
                user_phone = :user_phone,
                user_comment = :user_comment,
                date = :date,
                status = :status
            WHERE id = :id";

        // Fetching and returning results. A prepared statement is used.
        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->bindValue(':user_name', $userName, PDO::PARAM_STR);
        $result->bindValue(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindValue(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindValue(':date', $date, PDO::PARAM_STR);
        $result->bindValue(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }
}
