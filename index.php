<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use \App\Router AS Router;
use \App\View AS View;
use \App\ProductList;
use \App\Product\Product;

define('PUBLIC_DIR', __DIR__ . '/public');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Router::add(['/', '/add-product'], [View::class, 'index']);

Router::add('/populate', [ProductList::class, 'populate']);

Router::add("/\.(.+)$/", [View::class, 'resource'], regex: true);

Router::add('/products', [ProductList::class, 'list']);

Router::add('/products', [Product::class, 'create'], method: 'POST');

Router::add('/products', [ProductList::class, 'massDelete'], method: 'DELETE');

[$database, $tables] = require 'init.php';

Router::run($database);