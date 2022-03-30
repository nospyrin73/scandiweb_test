<?php

declare(strict_types = 1);

namespace App\Product;

use App\Utils\{Request, Response};
use App\Database\{Database, Query};

abstract class Product {
    protected string $name;

    protected float $price;

    protected string $type;

    public function __construct(
        protected string $sku,
    ) {
    }

    public function getSku(): string {
        return $this->sku;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setType(string $type) {
        $this->type = $type;
    }

    public function getType(): string {
        return $this->type;
    }

    public function insert(Database $db): int {
        $query = (new Query($db, $db->tables['Product']))
            ->insert([
                'sku' => '"' . $this->sku . '"',
                'name' => '"' . $this->name . '"',
                'price' => $this->price,
                'type' => '"' . $this->type . '"',
            ])
            ->execute();

        return $query->getResult()->rowCount();
    }

    abstract public function delete(Database $db): int;

    public static function create(Request $req, Response $res, Database $db): void {
        $product = null;

        $payload = $req->getPayload();

        // initialize object

        switch ($payload['type']) {
            case 'DVD':
                $product = new DVD($payload['sku']);

                $product->setSize((float) $payload['size']);
                
                break;
            case 'Furniture':
                $product = new Furniture($payload['sku']);

                $product->setHeight((float) $payload['height']);
                $product->setWidth((float) $payload['width']);
                $product->setLength((float) $payload['length']);
                
                break;
            case 'Book':
                $product = new Book($payload['sku']);

                $product->setWeight((float) $payload['weight']);
                
                break;
            default:
                // send error type mismatch
        }

        $product->setName($payload['name']);
        $product->setPrice((float) $payload['price']);
        $product->setType($payload['type']);

        
        if ($product->exists($db)) {
            $res->status(409, 'Duplicate Entry')->end();

            return;
        }
        
        // insert into db

        $inserted = $product->insert($db);

        if ($inserted) {
            $res->status(201, 'Created')->end();

            return;
        }

        $res->status(500, 'Failed');
    }

    public function exists(Database $db): bool {
        $query = (new Query($db, $db->tables['Product']))
            ->select(['*'])
            ->where()
            ->condition('sku', '=', '"' . $this->sku . '"')
            ->execute();

        if ($query->first()) return true;

        return false;
    }

    public function toMap(): array {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'type' => $this->type
        ];
    }
}