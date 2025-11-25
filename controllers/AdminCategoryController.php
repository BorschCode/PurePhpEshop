<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AdminBase;
use App\Models\Category;

/**
 * Created by PhpStorm.
 * Date: 10.12.2017
 * Time: 1:41
 */

/**
 * AdminCategoryController
 * Manages product categories in the admin panel
 */
final class AdminCategoryController extends AdminBase
{

    /**
     * Action for the "Manage Categories" page
     * @return bool
     */
    public function actionIndex(): bool
    {
        // Check admin access
        self::checkAdmin();

        // Get a list of categories for the admin panel
        $categoriesList = Category::getCategoriesListAdmin();

        // Include the view
        require_once ROOT . '/views/admin_category/index.php';
        return true;
    }

    /**
     * Action for the "Add Category" page
     * @return bool
     */
    public function actionCreate(): bool
    {
        // Check admin access
        self::checkAdmin();

        // Handle form submission
        if (isset($_POST['submit'])) {
            // If the form was submitted
            // Get data from the form
            $name = $_POST['name'] ?? '';
            $sortOrder = (int)($_POST['sort_order'] ?? 0);
            $status = (int)($_POST['status'] ?? 1);

            // Flag for form errors
            $errors = false;

            // Basic validation: check if the name is set and not empty
            if (empty($name)) {
                $errors[] = 'Fill in all required fields';
            }

            if (!$errors) {
                // If there are no errors, create the new category
                Category::createCategory($name, $sortOrder, $status);

                // Redirect the user to the category management page
                header("Location: /admin/category");
                exit();
            }
        }

        require_once ROOT . '/views/admin_category/create.php';
        return true;
    }

    /**
     * Action for the "Edit Category" page
     * @param int $id The ID of the category to edit
     * @return bool
     */
    public function actionUpdate(int $id): bool
    {
        // Check admin access
        self::checkAdmin();

        // Get data for the specific category
        $category = Category::getCategoryById($id);

        // Handle form submission
        if (isset($_POST['submit'])) {
            // If the form was submitted
            // Get data from the form
            $name = $_POST['name'] ?? '';
            $sortOrder = (int)($_POST['sort_order'] ?? 0);
            $status = (int)($_POST['status'] ?? 1);

            // Save the changes
            Category::updateCategoryById($id, $name, $sortOrder, $status);

            // Redirect the user to the category management page
            header("Location: /admin/category");
            exit();
        }

        // Include the view
        require_once ROOT . '/views/admin_category/update.php';
        return true;
    }

    /**
     * Action for the "Delete Category" page
     * @param int $id The ID of the category to delete
     * @return bool
     */
    public function actionDelete(int $id): bool
    {
        // Check admin access
        self::checkAdmin();

        // Handle form submission (confirmation)
        if (isset($_POST['submit'])) {
            // If the form was submitted, delete the category
            Category::deleteCategoryById($id);

            // Redirect the user to the category management page
            header("Location: /admin/category");
            exit();
        }

        // Include the view
        require_once ROOT . '/views/admin_category/delete.php';
        return true;
    }

}
