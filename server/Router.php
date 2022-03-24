<?php

declare(strict_types = 1);

namespace App;

use \App\Utils\{Request, Response};

class Router {
    private static array $routes = [];

    public static function add(
        string|array $paths,
        array $controller, 
        string $method = 'GET',
        bool $regex = false): void {

        $paths = is_array($paths) ? $paths : [$paths];

        foreach ($paths as $path) {
            array_push(self::$routes, [
                'path' => $path,
                'controller' => $controller,
                'method' => $method,
                'regex' => $regex
            ]);
        }
    }

    public static function run() {
        [
            'REQUEST_URI' => $requestUri,
            'REQUEST_METHOD' => $httpMethod,
            'CONTENT_TYPE' => $contentType
        ] = $_SERVER;

        $req = (new Request($requestUri, $httpMethod, $contentType))
            ->populateUrlSegments()
            ->populatePayload();
        $res = new Response();
        
        $path_found = false;
        foreach (self::$routes as $route) {
            if ($route['regex']) {
                $isMatch = preg_match($route['path'], $req->getPath());

                if ($isMatch) {
                    $path_found = true;

                    if ($route['method'] !== $req->getMethod()) continue;
                    
                    call_user_func_array($route['controller'], [$req, $res]);

                    return;
                }
            } else if ($req->getPath() === $route['path']) {
                $path_found = true;

                if ($route['method'] !== $req->getMethod()) continue;

                call_user_func_array($route['controller'], [$req, $res]);

                return;
            }
        }

        // path found but method mismatched
        if ($path_found) {
            $res->status(403, 'Forbidden Method');
        }
    }
}