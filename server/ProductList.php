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
}