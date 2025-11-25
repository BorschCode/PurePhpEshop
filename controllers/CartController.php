<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

/**
 * Created by PhpStorm.
 * User: George
 * Date: 09.12.2017
 * Time: 22:21
 */
final class CartController
{

    /**
     * Adds a product to the cart and redirects the user back to the previous page.
     * @param int $id The product ID.
     */
    public function actionAdd(int $id): void
    {
        // Add product to cart
        Cart::addProduct($id);

        // Redirect user back to the previous page
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $referrer");
        exit(); // Crucial to stop script execution after redirect
    }

    /**
     * Removes a single item of a product from the cart.
     * @param int $id The product ID.
     */
    public function actionDelete(int $id): void
    {
        // Remove product from cart
        Cart::deleteItem($id);

        // Redirect user to the cart page
        header("Location: /cart/");
        exit(); // Crucial to stop script execution after redirect
    }

    /**
     * Adds a product to the cart via AJAX and returns the new item count.
     * @param int $id The product ID.
     * @return bool
     */
    public function actionAddAjax(int $id): bool
    {
        // Add product to cart and echo the new count
        echo Cart::addProduct($id);
        return true;
    }

    /**
     * Displays the main shopping cart page.
     * @return bool
     */
    public function actionIndex(): bool
    {
        // Fetch categories for the menu
        $categories = Category::getCategoriesList();

        $productsInCart = false;
        $products = [];
        $totalPrice = 0;

        // Get product IDs and quantities from the cart session
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            // Get full product information for the list
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            // Get total cost of products
            $totalPrice = Cart::getTotalPrice($products);
        }

        $pageTitle = "Shopping Cart";
        $pageDescription = "Review and manage your items before checkout.";
        require_once ROOT . '/views/cart/index.php';

        return true;
    }

    /**
     * Handles the checkout process, including form validation and order placement.
     * @return bool
     */
    public function actionCheckout(): bool
    {
        // List of categories for the left menu
        $categories = Category::getCategoriesList();

        // Status of successful order placement
        $result = false;
        $errors = [];

        // Variables for the form (initialized as null for clarity)
        $userName = null;
        $userPhone = null;
        $userComment = null;

        // Cart and order details variables
        $productsInCart = Cart::getProducts();
        $products = [];
        $totalPrice = 0;
        $totalQuantity = 0;


        // Check if the form was submitted
        if (isset($_POST['submit'])) {
            // Form submitted - Yes

            // Read form data safely
            $userName = $_POST['userName'] ?? '';
            $userPhone = $_POST['userPhone'] ?? '';
            $userComment = $_POST['userComment'] ?? '';

            // --- Field validation ---
            if (!User::checkName($userName)) {
                $errors[] = 'Invalid name. Name must be at least 2 characters long.';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Invalid phone number.';
            }

            // Is the form filled out correctly?
            if (empty($errors)) {
                // Form filled out correctly - Yes

                // Gather order information
                $productsInCart = Cart::getProducts();
                $userId = User::isGuest() ? false : User::checkLogged();

                // Save order to DB
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    // Notify the administrator about the new order (optional)
                    $adminEmail = 'admin@test.com';
                    $message = 'http://wezom.test/admin/orders';
                    $subject = 'New order!';
                    // mail($adminEmail, $subject, $message);

                    // Clear the cart
                    Cart::clear();
                }
            } else {
                // Form filled out correctly? - No
                // Recalculate totals to display on the form again
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
            // Form submitted - No

            // Get data from cart
            $productsInCart = Cart::getProducts();

            // Are there items in the cart?
            if ($productsInCart === false) {
                // Items in cart - No
                // Redirect user to the homepage to find products
                header("Location: /");
                exit();
            } else {
                // Items in cart - Yes

                // Calculate totals: total price, total quantity
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                // Check if user is logged in to pre-fill the form
                if (!User::isGuest()) {
                    // Yes, logged in
                    // Get user information from DB by ID
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);

                    // Pre-fill the form with user data
                    $userName = $user['name'];
                }
            }
        }

        $pageTitle = "Checkout";
        $pageDescription = "Finalize your order and provide delivery details.";
        require_once ROOT . '/views/cart/checkout.php';

        return true;
    }

}
