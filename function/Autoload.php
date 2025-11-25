<?php

declare(strict_types=1);

spl_autoload_register(function (string $className): void {
    // List all the class directories in the array.
    $arrayPaths = [
        '/models/',
        '/function/'
    ];

    foreach ($arrayPaths as $path) {
        $filePath = ROOT . $path . $className . '.php';
        if (is_file($filePath)) {
            include_once $filePath;
            return;
        }
    }
});