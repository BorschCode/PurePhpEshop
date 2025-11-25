<?php
/**
 * Database connection parameters for Docker environment.
 */

return array(
    'host' => $_ENV['DB_HOST'] ?? 'db',
    'dbname' => $_ENV['DB_NAME'] ?? 'catalog',
    'user' => $_ENV['DB_USER'] ?? 'webuser',
    'password' => $_ENV['DB_PASSWORD'] ?? '123',
);