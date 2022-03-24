<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use \App\Router AS Router;
use \App\View AS StaticFiles;

define('PUBLIC_DIR', __DIR__ . '/public');

$server = new Router();

$server->get(['/', '/add-product'], [View::class, 'index']);

$server->get("/\.(.+)$/", [View::class, 'resource'], regex: true);

$server->get('/products', []);

$server->post('/products/create', []);

$server->post('/products/delete', []);

$server->run();