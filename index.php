<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use \App\Router AS Router;
use \App\View AS View;

define('PUBLIC_DIR', __DIR__ . '/public');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Router::add(['/', '/add-product'], [View::class, 'index']);

Router::add("/\.(.+)$/", [View::class, 'resource'], regex: true);

// Router::add('/products', []);

// Router::add('/products', [], $method: 'POST');

// Router::add('/products', [], $method: 'DELETE');

Router::run();