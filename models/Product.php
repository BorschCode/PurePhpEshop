<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Product Model (Utility Class).
 *
 * This model is responsible for handling all database operations related to products.
 */
final class Product
{
    /**
     * Default number of products to show on a page.
     */
    public const SHOW_BY_DEFAULT = 6;

    /**
     * Returns an array of the latest products.
     *
     * @param int $count The number of products to return.
     * @return array<int, array{id: int, tittle: string, price: float, price_new: float, is_new: int}> Array of products.
     */
    public static function getLatestProducts(int $count = self::SHOW_BY_DEFAULT): array
    {
        $db = \App\Core\Db::getConnection();

        $sql = 'SELECT id, tittle, price, price_new, is_new FROM products '
            . 'WHERE status = "1" ORDER BY id DESC '
            . 'LIMIT :count';

        $result = $db->prepare($sql);
        $result->bindValue(':count', $count, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $productsList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i] = [
                'id' => $row['id'],
                'tittle' => $row['tittle'],
                'price' => $row['price'],
                'price_new' => $row['price_new'],
                'is_new' => $row['is_new']
            ];
            $i++;
        }
        return $productsList;
    }

    /**
     * Returns a list of products in the specified category, with pagination.
     *
     * @param int $categoryId The ID of the category.
     * @param int $page The current page number.
     * @return array<int, array{id: int, tittle: string, price: float, price_new: float, is_new: int}> Array of products.
     */
    public static function getProductsListByCategory(int $categoryId, int $page = 1): array
    {
        $limit = self::SHOW_BY_DEFAULT;
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = \App\Core\Db::getConnection();

        $sql = 'SELECT id, tittle, price, price_new, is_new FROM products '
            . 'WHERE status = 1 AND category_id = :category_id '
            . 'ORDER BY id ASC LIMIT :limit OFFSET :offset';

        $result = $db->prepare($sql);
        $result->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $result->bindValue(':limit', $limit, PDO::PARAM_INT);
        $result->bindValue(':offset', $offset, PDO::PARAM_INT);
        $result->execute();

        $products = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i] = [
                'id' => $row['id'],
                'tittle' => $row['tittle'],
                'price' => $row['price'],
                'price_new' => $row['price_new'],
                'is_new' => $row['is_new']
            ];
            $i++;
        }
        return $products;
    }

    /**
     * Returns a product with the specified ID.
     *
     * @param int $id The ID of the product.
     * @return array<string, mixed>|false Array with product information or false if not found.
     */
    public static function getProductById(int $id): array|false
    {
        $db = \App\Core\Db::getConnection();

        $sql = 'SELECT * FROM products WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    /**
     * Returns the total number of products in the specified category.
     *
     * @param int $categoryId The ID of the category.
     * @return int The total count of products.
     */
    public static function getTotalProductsInCategory(int $categoryId): int
    {
        $db = \App\Core\Db::getConnection();

        $sql = 'SELECT count(id) AS count FROM products WHERE status="1" AND category_id = :category_id';

        $result = $db->prepare($sql);
        $result->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $result->execute();

        $row = $result->fetch();
        return (int) $row['count'];
    }

    /**
     * Returns a list of products with the specified identifiers (used primarily for cart display).
     *
     * @param int[] $idsArray Array with product IDs.
     * @return array<int, array{id: int, code: string, tittle: string, price: float}> Array with the list of products.
     */
    public static function getProductsByIds(array $idsArray): array
    {
        $db = \App\Core\Db::getConnection();

        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM products WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $products = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i] = [
                'id' => $row['id'],
                'code' => $row['code'],
                'tittle' => $row['tittle'],
                'price' => $row['price']
            ];
            $i++;
        }
        return $products;
    }

    /**
     * Returns a list of recommended products.
     *
     * @return array<int, array{id: int, tittle: string, price: float, price_new: float, is_new: int}> Array of products.
     */
    public static function getRecommendedProducts(): array
    {
        $db = \App\Core\Db::getConnection();

        $result = $db->query('SELECT id, tittle, price, price_new, is_new FROM products '
            . 'WHERE status = "1" AND is_recommended = "1" '
            . 'ORDER BY id DESC');

        $productsList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i] = [
                'id' => $row['id'],
                'tittle' => $row['tittle'],
                'price' => $row['price'],
                'price_new' => $row['price_new'],
                'is_new' => $row['is_new']
            ];
            $i++;
        }
        return $productsList;
    }

    /**
     * Returns a list of all products (for admin panel).
     *
     * @return array<int, array{id: int, tittle: string, price: float, price_new: float, category_id: int, code: string}> Array of products.
     */
    public static function getProductsList(): array
    {
        $db = \App\Core\Db::getConnection();

        $result = $db->query('SELECT id, tittle, price, price_new, category_id, code FROM products ORDER BY id ASC');

        $productsList = [];
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i] = [
                'id' => $row['id'],
                'tittle' => $row['tittle'],
                'code' => $row['code'],
                'price' => $row['price'],
                'price_new' => $row['price_new'],
                'category_id' => $row['category_id']
            ];
            $i++;
        }
        return $productsList;
    }

    /**
     * Deletes a product with the specified ID.
     *
     * @param int $id The ID of the product to delete.
     * @return bool Result of the method execution.
     */
    public static function deleteProductById(int $id): bool
    {
        $db = \App\Core\Db::getConnection();

        $sql = 'DELETE FROM products WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Edits/updates a product with the specified ID.
     *
     * @param int $id The ID of the product.
     * @param array<string, mixed> $options Array with product information (fields to update).
     * @return bool Result of the method execution.
     */
    public static function updateProductById(int $id, array $options): bool
    {
        $db = \App\Core\Db::getConnection();

        $sql = "UPDATE products
            SET
                tittle = :tittle,
                code = :code,
                price = :price,
                price_new = :price_new,
                category_id = :category_id,
                brand = :brand,
                availability = :availability,
                description = :description,
                is_new = :is_new,
                is_recommended = :is_recommended,
                status = :status,
                categories  = :categories
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->bindValue(':tittle', $options['tittle'], PDO::PARAM_STR);
        $result->bindValue(':code', $options['code'], PDO::PARAM_STR);
        $result->bindValue(':price', $options['price'], PDO::PARAM_STR);
        $result->bindValue(':price_new', $options['price_new'], PDO::PARAM_STR);
        $result->bindValue(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindValue(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindValue(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindValue(':description', $options['description'], PDO::PARAM_STR);
        $result->bindValue(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindValue(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindValue(':status', $options['status'], PDO::PARAM_INT);
        $result->bindValue(':categories', $options['categories'], PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Adds a new product to the database.
     *
     * @param array<string, mixed> $options Array with product information.
     * @return int The ID of the newly inserted record, or 0 on failure.
     */
    public static function createProduct(array $options): int
    {
        $db = \App\Core\Db::getConnection();

        $sql = 'INSERT INTO products '
            . '(tittle, code, price, price_new, category_id, brand, availability,'
            . 'description, is_new, is_recommended, status, breadcrumbs, metatags, categories)'
            . 'VALUES '
            . '(:tittle, :code, :price, :price_new, :category_id, :brand, :availability,'
            . ':description, :is_new, :is_recommended, :status, :breadcrumbs, :metatags, :categories)';

        $result = $db->prepare($sql);
        $result->bindValue(':tittle', $options['tittle'], PDO::PARAM_STR);
        $result->bindValue(':code', $options['code'], PDO::PARAM_INT);
        $result->bindValue(':price', $options['price'], PDO::PARAM_STR);
        $result->bindValue(':price_new', $options['price_new'] ?? 0, PDO::PARAM_STR);
        $result->bindValue(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindValue(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindValue(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindValue(':description', $options['description'], PDO::PARAM_STR);
        $result->bindValue(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindValue(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindValue(':status', $options['status'], PDO::PARAM_INT);
        $result->bindValue(':breadcrumbs', $options['breadcrumbs'] ?? '', PDO::PARAM_STR);
        $result->bindValue(':metatags', $options['metatags'] ?? '', PDO::PARAM_STR);
        $result->bindValue(':categories', $options['categories'] ?? '[]', PDO::PARAM_STR);

        if ($result->execute()) {
            return (int) $db->lastInsertId();
        }
        return 0;
    }

    /**
     * Returns the textual explanation of product availability.
     *
     * @param int|string $availability The availability status (0 or 1).
     * @return string The textual explanation in Ukrainian.
     */
    public static function getAvailabilityText(int|string $availability): string
    {
        return match ((string) $availability) {
            '1' => 'В наявності',
            '0' => 'Під замовлення',
            default => 'Невідомо',
        };
    }

    /**
     * Returns the path to the 110x110 px image.
     *
     * @param int $id The ID of the product.
     * @return string The path to the image or a placeholder.
     */
    public static function getLowImage(int $id): string
    {
        $noImage = 'no_image_110.jpg';
        $path = '/upload/images/products/';
        $pathToProductImage = $path . $id . '/product_110.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)) {
            return $pathToProductImage;
        }

        return $path . $noImage;
    }

    /**
     * Returns the path to the 250x250 px image.
     *
     * @param int $id The ID of the product.
     * @return string The path to the image or a placeholder.
     */
    public static function getMediumImage(int $id): string
    {
        $noImage = 'no_image_250.jpg';
        $path = '/upload/images/products/';
        $pathToProductImage = $path . $id . '/product_250.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)) {
            return $pathToProductImage;
        }

        return $path . $noImage;
    }

    /**
     * Returns the path to the 450x450 px image.
     *
     * @param int $id The ID of the product.
     * @return string The path to the image or a placeholder.
     */
    public static function getLargeImage(int $id): string
    {
        $noImage = 'no_image_450.jpg';
        $path = '/upload/images/products/';
        $pathToProductImage = $path . $id . '/product_450.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)) {
            return $pathToProductImage;
        }

        return $path . $noImage;
    }
}
