<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Cart Model (Utility Class).
 *
 * This class handles all shopping cart logic, including adding, removing, counting,
 * and calculating the total price of products stored in the PHP session ('products').
 */
final class Cart
{
    /**
     * Adds a product to the shopping cart (stored in session).
     * If the product already exists, its quantity is incremented.
     *
     * @param int $id The ID of the product to add.
     * @return int The new total count of items in the cart.
     */
    public static function addProduct(int $id): int
    {
        $productsInCart = $_SESSION['products'] ?? [];

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id]++;
        } else {
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }

    /**
     * Counts the total number of items in the cart (stored in session).
     *
     * @return int The total number of items in the cart. Returns 0 if the cart is empty.
     */
    public static function countItems(): int
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count += $quantity;
            }
            return $count;
        }
        return 0;
    }

    /**
     * Retrieves the list of product IDs and their quantities from the session.
     *
     * @return array<int, int>|false An associative array of product IDs and quantities (e.g., [id => quantity]) or false if the cart is empty.
     */
    public static function getProducts(): array|false
    {
        return $_SESSION['products'] ?? false;
    }

    /**
     * Calculates the total price of the products currently in the cart.
     * Requires an array of full product details (including price).
     *
     * @param array<int, array<string, mixed>> $products An array of product details (from the database) that are currently in the cart.
     * @return float The total price of all items in the cart.
     */
    public static function getTotalPrice(array $products): float
    {
        $productsInCart = self::getProducts();
        $total = 0.0;

        if ($productsInCart) {
            foreach ($products as $item) {
                if (array_key_exists($item['id'], $productsInCart)) {
                    $total += $item['price'] * $productsInCart[$item['id']];
                }
            }
        }

        return $total;
    }

    /**
     * Clears the entire shopping cart (removes the 'products' session variable).
     *
     * @return void
     */
    public static function clear(): void
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * Deletes one item instance (decrements quantity) or removes the product entirely from the cart.
     *
     * @param int $id The ID of the product to decrement/remove.
     * @return int The new total count of items in the cart.
     */
    public static function deleteItem(int $id): int
    {
        if (!isset($_SESSION['products'])) {
            return 0;
        }

        $productsInCart = $_SESSION['products'];

        if (array_key_exists($id, $productsInCart) && $productsInCart[$id] > 1) {
            $productsInCart[$id]--;
        } elseif (array_key_exists($id, $productsInCart)) {
            unset($productsInCart[$id]);
        }

        $_SESSION['products'] = $productsInCart;
        return self::countItems();
    }
}
