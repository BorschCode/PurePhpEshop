<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

/**
 * Created by PhpStorm.
 * Date: 08.12.2017
 * Time: 09:50
 */
final class ProductController
{
    public function actionView(int $productId): bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId);

        $pageTitle = "Product description ".$product['tittle'];
        $pageDescription = "Specifications ".$product['tittle'];
        require_once ROOT . '/views/product/view.php';

        return true;

    }
}
