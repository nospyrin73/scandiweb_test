<?php

declare(strict_types = 1);

namespace App;

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
}