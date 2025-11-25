<?php

declare(strict_types=1);

namespace App\Core;

use Exception;

/**
 * Class Router
 * Core class for handling URL routing and dispatching requests to controllers.
 */
final class Router
{
    private array $routes;

    /**
     * Constructor: loads the routes configuration file.
     */
    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        // Load the routes array from the configuration file
        $this->routes = include $routesPath;
    }

    /**
     * Retrieves the request URI and trims slashes.
     */
    private function getURI(): string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            // Trim leading and trailing slashes
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        return '';
    }


    /**
     * Runs the router:
     * 1. Gets the URI.
     * 2. Matches the URI against patterns defined in routes.php.
     * 3. Dispatches the request to the appropriate Controller and Action.
     */
    public function run(): void
    {
        // Get the request URI
        $uri = $this->getURI();

        // Check if the URI matches any pattern in the routes
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                // Create the internal route path by replacing the pattern in the URI
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Determine controller, action, and parameters
                $segments = explode('/', $internalRoute);

                // Controller name (e.g., ProductController)
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';

                // Fully qualified controller class name with namespace
                $controllerClass = "App\\Controllers\\{$controllerName}";

                // Action name (e.g., actionView)
                $actionName = 'action' . ucfirst(array_shift($segments) ?? '');

                // Remaining segments are parameters
                $parameters = $segments;

                // Check if the controller class exists (autoloader will handle loading)
                if (!class_exists($controllerClass)) {
                    error_log("Router Error: Controller class $controllerClass not found");
                    echo "An error occurred while dispatching the request.";
                    return;
                }

                // Create an object of the controller class
                $controllerObject = new $controllerClass();

                // Call the action method using the collected parameters
                try {
                    $result = call_user_func_array([$controllerObject, $actionName], $parameters);
                } catch (Exception $e) {
                    // Display the error message instead of just calling getMessage()
                    error_log("Router Error: " . $e->getMessage());
                    echo "An error occurred while dispatching the request.";
                    return;
                }

                // If the action returned a non-null result, routing is complete
                if ($result !== null) {
                    break;
                } else {
                    // Default fallback if the controller action didn't return a result (preserved original logic)
                    require_once ROOT . '/views/about/index.php';
                }
            }
        }
    }
}