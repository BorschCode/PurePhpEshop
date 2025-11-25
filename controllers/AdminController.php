<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AdminBase;

/**
 * Created by PhpStorm.
 * User: George
 * Date: 10.12.2017
 * Time: 1:12
 */

/**
 * AdminController
 * Main controller for the Admin Panel start page
 */
final class AdminController extends AdminBase
{
    /**
     * Action for the main "Administrator Panel" start page.
     * @return bool
     */
    public function actionIndex(): bool
    {
        // Access check: ensures only admin users can access this page
        self::checkAdmin();

        // Connect view
        require_once ROOT . '/views/admin/index.php';
        return true;
    }

}
