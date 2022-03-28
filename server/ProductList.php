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
                    $products[] = new DVD(
                        $row['sku'],
                        $row['name'],
                        $row['price'],
                        $row['type'],
                        $row['size']
                    );
                    break;
                case 'Furniture':
                    $products[] = new Furniture(
                        $row['sku'],
                        $row['name'],
                        $row['price'],
                        $row['type'],
                        $row['height'],
                        $row['width'],
                        $row['length']
                    );
                    break;
                case 'Book':
                    $products[] = new Book(
                        $row['sku'],
                        $row['name'],
                        $row['price'],
                        $row['type'],
                        $row['weight']
                    );
            }
        }

        $res->json(array_map(fn($p) => $p->toMap(), $products));
    }
}