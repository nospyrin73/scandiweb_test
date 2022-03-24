<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use \App\Router AS Router;
use \App\View AS View;

define('PUBLIC_DIR', __DIR__ . '/public');

$server = new Router();

$server->add(['/', '/add-product'], [View::class, 'index']);

$server->add("/\.(.+)$/", [View::class, 'resource'], regex: true);

// $server->add('/products', []);

// $server->add('/products/create', [], $method: 'POST');

// $server->post('/products/delete', [], $method: 'POST');

$server->run();