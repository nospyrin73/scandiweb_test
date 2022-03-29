<?php

declare(strict_types = 1);

namespace App;

use App\Utils\{Request, Response};
use App\Database\{Database, Query};
use App\Product\{DVD, Furniture, Book};

class ProductList {
    public static function list(Request $req, Response $res, Database $db) {
        $query = (new Query($db, $db->tables['Product']))
            ->select([
                'Product.sku', 'name', 'price', 'type',
                'size',
                'height', 'width', 'length',
                'weight'
                ])
            ->join('LEFT', 'DVD', 'sku')
            ->join('LEFT', 'Furniture', 'sku')
            ->join('LEFT', 'Book', 'sku')
            ->execute();
        
        $result = $query->all();

        $products = [];

        foreach ($result as $row) {
            switch ($row['type']) {
                case 'DVD':
                    $dvd = new DVD($row['sku']);

                    $dvd->setName($row['name']);
                    $dvd->setPrice($row['price']);
                    $dvd->setType($row['type']);
                    $dvd->setSize($row['size']);

                    $products[] = $dvd;
                    break;
                case 'Furniture':
                    $furn = new Furniture($row['sku']);

                    $furn->setName($row['name']);
                    $furn->setPrice($row['price']);
                    $furn->setType($row['type']);
                    $furn->setHeight($row['height']);
                    $furn->setWidth($row['width']);
                    $furn->setLength($row['length']);
                    
                    $products[] = $furn;
                    break;
                case 'Book':
                    $book = new Book($row['sku']);

                    $book->setName($row['name']);
                    $book->setPrice($row['price']);
                    $book->setType($row['type']);
                    $book->setWeight($row['weight']);

                    $products[] = $book;
                    break;
            }
        }

        $res->json(
            array_map(
                fn($p) => $p->toMap(),
                $products
            )
        );
    }

    public static function massDelete($req, $res, $db) {
        $products = $req->getPayload()['filtered'];

        $deleted = [];

        foreach ($products as $p) {
            switch ($p['type']) {
                case 'DVD':
                    $dvd = new DVD($p['sku']);
                    
                    if ($dvd->delete($db)) {
                        $deleted[] = $dvd->getSku();
                    }

                    break;
                case 'Furniture':
                    $furn = new Furniture($p['sku']);
                    
                    if ($furn->delete($db)) {
                        $deleted[] = $furn->getSku();
                    }

                    break;
                case 'Book':
                    $book = new Book($p['sku']);

                    if ($book->delete($db)) {
                        $deleted[] = $book->getSku();
                    }

                    break;
            }
        }

        $res->json($deleted);
    }

    public static function populate($req, $res, $db) {
        try {
            (new Query($db, $db->tables['Product']))
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

            (new Query($db, $db->tables['DVD']))
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

            (new Query($db, $db->tables['Furniture']))
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

            (new Query($db, $db->tables['Book']))
            ->insert([
                'sku' => [
                    '"BK100"', '"BK102"', '"BK103"'
                ],
                'weight' => [
                    1.03, 1.17, 1.04
                ]
            ], multiple: true)
            ->execute();
        } catch (\PDOException $e) {
            // error_log($e->getMessage() . ' - ' . $e->getFile() . ': ' . $e->getLine());

            echo $e->getMessage();
        }
    }
}