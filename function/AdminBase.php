<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * Abstract class AdminBase contains common logic for controllers
 * used in the admin panel
 */
abstract class AdminBase
{
    /**
     * Method that checks if the user is an administrator
     */
    public static function checkAdmin(): bool
    {
        // Check if the user is authorized. If not, they will be redirected
        $userId = \App\Models\User::checkLogged();

        // Get information about the current user
        $user = \App\Models\User::getUserById($userId);

        // If the current user's role is "admin", allow access to the admin panel
        if ($user && $user['role'] === 'admin') {
            return true;
        }

        // Otherwise, terminate execution with an access denied message
        throw new RuntimeException('Access denied');
    }
}
