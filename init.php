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

// ---------

try {


    (new Query($database, $product))
    ->insert([
        'sku' => [
            '"DVD100"', '"DVD101"', '"DVD102"',
            '"DVD103"', '"DVD104"', '"DVD105"',
            '"Furn100"', '"Furn101"', '"Furn102"',
            '"BK100"', '"BK102"', '"BK103"'
        ],
        'name' => [
            '"Game of Thrones Complete Series"', '"Breakin Bad Complete Series"', '"Attack on Titan: Final Season Digital"',
            '"Mr. Robot The Complete Series"', '"The Office"', '"Peaky Blinders"',
            '"Grayson Sofa"', '"Queen Select Bed"', '"Dining Chair"',
            '"A Song of Ice and Fire"', '"The Wheel of Time"', '"IT"'
        ],
        'price' => [
            89.0, 105.24, 18.48,
            24.0, 34.99, 16.14,
            405.22, 86.99, 156.75,
            24.0, 16.32, 15.89
        ],
        'type' => [
            '"DVD"', '"DVD"', '"DVD"',
            '"DVD"', '"DVD"', '"DVD"',
            '"Furniture"', '"Furniture"', '"Furniture"',
            '"Book"', '"Book"', '"Book"'
        ]
    ], multiple: true)
    ->execute();



    (new Query($database, $dvd))
    ->insert([
        'sku' => [
            '"DVD100"', '"DVD101"', '"DVD102"',
            '"DVD103"', '"DVD104"', '"DVD105"'
        ],
        'size' => [
            4048.18, 2224.4, 1803.01,
            4287.3, 3307.0, 2036.26
        ]
    ], multiple: true)
    ->execute();

    (new Query($database, $furniture))
    ->insert([
        'sku' => [
            '"Furn100"', '"Furn101"', '"Furn102"'
        ],
        'height' => [
            76, 16, 18
        ],
        'width' => [
            31, 63, 25
        ],
        'length' => [
            32, 83, 38
        ]
    ], multiple: true)
    ->execute();

    (new Query($database, $book))
    ->insert([
        'sku' => [
            '"BK100"', '"BK102"', '"BK103"'
        ],
        'weight' => [
            1.03, 1.17, 1.04
        ]
    ], multiple: true)
    ->execute();
} catch (PDOException $e) {
    // error_log($e->getMessage() . ' - ' . $e->getFile() . ': ' . $e->getLine());
}

return [
    $database, 
    ['Product' => $product, 'DVD' => $dvd, 'Furniture' => $furniture, 'Book' => $book]
];