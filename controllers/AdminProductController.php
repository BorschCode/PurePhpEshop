<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AdminBase;
use App\Models\Product;
use App\Models\Category;
use App\Core\SimpleImage;

/**
 * Created by PhpStorm.
 * User: George
 * Date: 10.12.2017
 * Time: 1:25
 */

/**
 * AdminProductController
 * Manages products in the admin panel
 */
final class AdminProductController extends AdminBase
{

    /**
     * Action for the "Manage Products" page.
     * @return bool
     */
    public function actionIndex(): bool
    {
        // Check admin access
        self::checkAdmin();

        // Fetch the list of all products
        $productsList = Product::getProductsList();

        // Include the view file
        require_once ROOT . '/views/admin_product/index.php';
        return true;
    }

    /**
     * Action for the "Add Product" page.
     * @return bool
     */
    public function actionCreate(): bool
    {
        // Check admin access
        self::checkAdmin();

        // Fetch the list of categories for the dropdown
        $categoriesList = Category::getCategoriesListAdmin();

        $errors = [];
        $options = [];

        // Form processing
        if (isset($_POST['submit'])) {
            // Retrieve data from the form
            $options['tittle'] = $_POST['tittle'] ?? '';
            $options['code'] = filter_var($_POST['code'] ?? '', FILTER_VALIDATE_INT) ?: 0;
            $options['price'] = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
            $options['price_new'] = filter_var($_POST['price_new'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0;
            $options['category_id'] = filter_var($_POST['category_id'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
            $options['brand'] = $_POST['brand'] ?? '';
            $options['availability'] = filter_var($_POST['availability'] ?? 1, FILTER_VALIDATE_INT) ?: 1;
            $options['description'] = $_POST['description'] ?? '';
            $options['is_new'] = filter_var($_POST['is_new'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
            $options['is_recommended'] = filter_var($_POST['is_recommended'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
            $options['status'] = filter_var($_POST['status'] ?? 1, FILTER_VALIDATE_INT) ?: 1;

            // Validate values as necessary
            if (empty($options['tittle'])) {
                $errors[] = 'Please fill in the product title.';
            }

            if ($options['code'] === 0 && !empty($_POST['code'])) {
                $errors[] = 'Product code must be a valid number.';
            }

            if (empty($errors)) {
                // If there are no errors, add the new product
                $id = Product::createProduct($options);

                // If the record was successfully added
                if ($id) {
                    // Check if an image file was uploaded via the form
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                        // Desired full path for product image directory
                        $structure = "/upload/images/products/{$id}";
                        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $structure;

                        // Create the directory if it doesn't exist (recursive)
                        if (!is_dir($fullPath)) {
                            if (!mkdir($fullPath, 0777, true)) {
                                // Error handling: Failed to create directory
                                // In a real system, this should be logged, not die()
                                die("Failed to create directories for product ID {$id}.");
                            }
                        }

                        // Define file path after move
                        $fileNamePath_450 = "{$fullPath}/product_450.jpg";

                        // Move the uploaded file
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $fileNamePath_450)) {
                            // Resize the uploaded image to 450x450
                            $image = new SimpleImage();
                            $image->load($fileNamePath_450);
                            $image->resize(450, 450);
                            $image->save($fileNamePath_450);

                            // Resize to 250x250
                            $fileNamePath_250 = "{$fullPath}/product_250.jpg";
                            $image->resize(250, 250);
                            $image->save($fileNamePath_250);

                            // Resize to 110x110
                            $fileNamePath_110 = "{$fullPath}/product_110.jpg";
                            $image->resize(110, 110);
                            $image->save($fileNamePath_110);
                        }
                    }
                }

                // Redirect user to the product management page
                header("Location: /admin/product");
                exit();
            }
        }

        // Include the view file
        require_once ROOT . '/views/admin_product/create.php';
        return true;
    }

    /**
     * Action for the "Edit Product" page.
     * @param int $id The product ID to edit.
     * @return bool
     */
    public function actionUpdate(int $id): bool
    {
        // Check admin access
        self::checkAdmin();

        // Fetch the list of categories for the dropdown
        $categoriesList = Category::getCategoriesListAdmin();

        // Get data for the specific product
        $product = Product::getProductById($id);

        // Form processing
        if (isset($_POST['submit'])) {
            // Retrieve data from the edit form. Validate values as necessary
            $options['tittle'] = $_POST['tittle'] ?? $product['tittle'];
            $options['code'] = filter_var($_POST['code'] ?? $product['code'], FILTER_VALIDATE_INT) ?: (int)$product['code'];
            $options['price'] = filter_var($_POST['price'] ?? $product['price'], FILTER_VALIDATE_FLOAT) ?: (float)$product['price'];
            $options['price_new'] = filter_var($_POST['price_new'] ?? $product['price_new'], FILTER_VALIDATE_FLOAT) ?: (float)$product['price_new'];
            $options['category_id'] = filter_var($_POST['category_id'] ?? $product['category_id'], FILTER_VALIDATE_INT) ?: (int)$product['category_id'];
            // Store multiple categories as a JSON string
            $options['categories'] = json_encode($_POST['categories'] ?? []);
            $options['brand'] = $_POST['brand'] ?? $product['brand'];
            $options['availability'] = filter_var($_POST['availability'] ?? $product['availability'], FILTER_VALIDATE_INT) ?: (int)$product['availability'];
            $options['description'] = $_POST['description'] ?? $product['description'];
            $options['is_new'] = filter_var($_POST['is_new'] ?? $product['is_new'], FILTER_VALIDATE_INT) ?: (int)$product['is_new'];
            $options['is_recommended'] = filter_var($_POST['is_recommended'] ?? $product['is_recommended'], FILTER_VALIDATE_INT) ?: (int)$product['is_recommended'];
            $options['status'] = filter_var($_POST['status'] ?? $product['status'], FILTER_VALIDATE_INT) ?: (int)$product['status'];

            // Save changes
            if (Product::updateProductById($id, $options)) {

                // Check if an image file was uploaded via the form
                if (is_uploaded_file($_FILES["image"]["tmp_name"]))
                {
                    // Desired full path for product image directory
                    $structure = "/upload/images/products/{$id}";
                    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $structure;

                    // Create the directory if it doesn't exist (recursive)
                    if (!is_dir($fullPath)) {
                        if (!mkdir($fullPath, 0777, true)) {
                            // Error handling: Failed to create directory
                            die("Failed to create directories for product ID {$id}.");
                        }
                    }

                    // Define file path after move
                    $fileNamePath_450 = "{$fullPath}/product_450.jpg";

                    // Move the uploaded file
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $fileNamePath_450)) {
                        // Resize the uploaded image to 450x450
                        $image = new SimpleImage();
                        $image->load($fileNamePath_450);
                        $image->resize(450, 450);
                        $image->save($fileNamePath_450);

                        // Resize to 250x250
                        $fileNamePath_250 = "{$fullPath}/product_250.jpg";
                        $image->resize(250, 250);
                        $image->save($fileNamePath_250);

                        // Resize to 110x110
                        $fileNamePath_110 = "{$fullPath}/product_110.jpg";
                        $image->resize(110, 110);
                        $image->save($fileNamePath_110);
                    }
                }
            }
            // Redirect user to the product management page
            header("Location: /admin/product");
            exit();
        }

        // Include the view file
        require_once ROOT . '/views/admin_product/update.php';
        return true;
    }

    /**
     * Action for the "Delete Product" page.
     * @param int $id The product ID to delete.
     * @return bool
     */
    public function actionDelete(int $id): bool
    {
        // Check admin access
        self::checkAdmin();

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form was submitted, delete the product
            Product::deleteProductById($id);

            // Redirect user to the product management page
            header("Location: /admin/product");
            exit();
        }

        // Include the view file (displays confirmation form)
        require_once ROOT . '/views/admin_product/delete.php';
        return true;
    }
}
