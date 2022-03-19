<?php

declare(strict_types = 1);

namespace App;

class Router {
    private array $routes = [];

    private function register(string $route, array $controller, string $method) {
        array_push($this->routes, [
            'route' => $route,
            'controller' => $controller,
            'method' => $method
        ]);
    }

    public function get(string $route, array $controller): void {
        $this->register($route, $controller, 'GET');
    }

    public function post(string $route, array $controller): void {
        $this->register($route, $controller, 'POST');
    }
}