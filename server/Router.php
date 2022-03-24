<?php

declare(strict_types = 1);

namespace App;

use \App\Utils\{Request, Response};

class Router {
    private array $routes = [];

    public function get(string|array $paths, array $controller, bool $regex = false): void {
        $paths = is_array($paths) ? $paths : [$paths];

        foreach ($paths as $path) {
            array_push($this->routes, [
                'path' => $path,
                'controller' => $controller,
                'method' => 'GET',
                'regex' => $regex
            ]);
        }
    }

    public function post(string $paths, array $controller, bool $regex = false): void {
        $paths = is_array($paths) ? $paths : [$paths];

        foreach ($paths as $path) {
            array_push($this->routes, [
                'path' => $path,
                'controller' => $controller,
                'method' => 'GET',
                'regex' => $regex
            ]);
        }
    }

    public function run() {
        [
            'REQUEST_URI' => $requestUri,
            'REQUEST_METHOD' => $httpMethod,
            'CONTENT_TYPE' => $contentType
        ] = $_SERVER;

        $req = (new Request($requestUri, $httpMethod, $contentType))
            ->populateUrlSegments()
            ->populatePayload();
        $res = new Response();
        
        foreach ($this->routes as $route) {
            if ($route['regex']) {
                $isMatch = preg_match($route['path'], $req->getPath());

                if ($isMatch) {
                    call_user_func_array($route['controller'], [$req, $res]);
                }
            } else if ($req->getPath() === $route['path']) {
                call_user_func_array($route['controller'], [$req, $res]);
            }
        }
    }
}