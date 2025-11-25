<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Core\Pagination;

final class CatalogController
{
    /**
     * Handles the display of the main catalog page.
     */
    public function actionIndex(): bool
    {
        // Fetch the list of all categories
        $categories = Category::getCategoriesList();

        // Fetch the 12 latest products for the main catalog view
        $latestProducts = Product::getLatestProducts(12);

        $pageTitle = "Product Catalog";
        $pageDescription = "Browse all product categories and latest items.";

        require_once ROOT . '/views/catalog/index.php';

        return true;
    }

    /**
     * Displays a list of products belonging to a specific category, with pagination.
     * * @param int $categoryId The ID of the category.
     * @param int $page The current page number (defaults to 1).
     */
    public function actionCategory(int $categoryId, int $page = 1): bool
    {
        // Fetch the list of all categories (usually for the sidebar/menu)
        $categories = Category::getCategoriesList();

        // Fetch products for the given category and page
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        // Get the total number of products in this category
        $total = Product::getTotalProductsInCategory($categoryId);

        // Create a Pagination object
        // SHOW_BY_DEFAULT is assumed to be a constant defined in the Product model
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        $pageTitle = "Category Listing";
        // Fetch the text description or name for the current category
        $pageDescription = Category::getCategoryText($categoryId);

        require_once ROOT . '/views/catalog/category.php';

        return true;
    }

}
