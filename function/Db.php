<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use RuntimeException;

/**
 * Class Db - Establishes PDO database connection
 */
final class Db
{
    /**
     * Connects to the database using parameters from db_params.php
     */
    public static function getConnection(): PDO
    {
        // Path to database connection parameters
        $paramsPath = file_exists(ROOT . '/config/db_params_docker.php') && getenv('DB_HOST') 
            ? ROOT . '/config/db_params_docker.php'
            : ROOT . '/config/db_params.php';
        $params = include $paramsPath;

        // Data Source Name (DSN)
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";

        try {
            // Establish the PDO connection
            $db = new PDO($dsn, $params['user'], $params['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // $db->exec("set names utf8"); // Uncomment this if there are encoding issues (like hieroglyphs) on the website

            return $db;
        } catch (PDOException $e) {
            // Display error message if connection fails
            error_log("Database connection error: " . $e->getMessage());

            // include(ROOT.'/function/errorPage.php'); // redirect for the error page

            // Terminate script with a detailed error message
            throw new RuntimeException('MySQL received an invalid request or incorrect data for database interaction.', 0, $e);
        }
    }
}