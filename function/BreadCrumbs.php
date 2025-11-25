<?php

declare(strict_types=1);

namespace App\Core;

final class BreadCrumbs
{
    public static function run(): void
    {
        $path = $_SERVER["PHP_SELF"] ?? '';
        $parts = explode('/', $path);

        if (count($parts) < 2) {
            echo "Home страница";
        } else {
            echo '<a href="/">Home</a> &raquo; ';
            for ($i = 1; $i < count($parts); $i++) {
                if (!str_contains($parts[$i], '.')) {
                    echo '<a href="';
                    for ($j = 0; $j <= $i; $j++) {
                        echo $parts[$j] . '/';
                    }
                    echo '">' . str_replace('-', ' ', $parts[$i]) . '</a> » ';
                } else {
                    $str = $parts[$i];
                    $pos = strrpos($str, '.');
                    $parts[$i] = substr($str, 0, $pos);
                    echo str_replace('-', ' ', $parts[$i]);
                }
            }
        }
    }
}
