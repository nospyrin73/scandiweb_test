<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use \App\Router AS Router;

$server = new Router();

$server->get('/', []);

$server->get('/add-product', []);

$server->get('products', []);

$server->post('/products/create', []);

$server->post('/products/delete', []);