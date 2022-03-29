<?php

// disable error reporting

ini_set('display_errors', false);

// populate the database with dummy data

use App\Database\{Database, Table, Query};

$database = new Database();

// Product Table Creation

$product = new Table($database, 'Product');

$product
->addField('sku', 'VARCHAR(30)', ['PRIMARY KEY'])
->addField('name', 'VARCHAR(255)', ['NOT NULL'])
->addField('price', 'FLOAT', ['NOT NULL'])
->addField('type', 'VARCHAR(10)', ['NOT NULL'])
->addIndex('indx_prod', ['sku'])
->build()
->create();

// DVD Table Creation

$dvd = new Table($database, 'DVD');

$dvd
->addField('sku', 'VARCHAR(30)', ['PRIMARY KEY'])
->addField('size', 'FLOAT', ['NOT NULL'])
->addForeignKey(
    'dvd_fk',
    ['sku'],
    'Product',
    ['sku'],
    onDelete: 'CASCADE'
)
->addIndex('indx_dvd', ['sku'])
->build()
->create();

// Furniture Table Creation

$furniture = new Table($database, 'Furniture');

$furniture
->addField('sku', 'VARCHAR(30)', ['PRIMARY KEY'])
->addField('height', 'FLOAT', ['NOT NULL'])
->addField('width', 'FLOAT', ['NOT NULL'])
->addField('length', 'FLOAT', ['NOT NULL'])
->addForeignKey(
    'furn_fk',
    ['sku'],
    'Product',
    ['sku'],
    onDelete: 'CASCADE'
)
->addIndex('indx_furn', ['sku'])
->build()
->create();

// Book Table Creation

$book = new Table($database, 'Book');

$book
->addField('sku', 'VARCHAR(30)', ['PRIMARY KEY'])
->addField('weight', 'FLOAT', ['NOT NULL'])
->addForeignKey(
    'book_fk',
    ['sku'],
    'Product',
    ['sku'],
    onDelete: 'CASCADE'
)
->addIndex('indx_book', ['sku'])
->build()
->create();

return [
    $database, 
    ['Product' => $product, 'DVD' => $dvd, 'Furniture' => $furniture, 'Book' => $book]
];