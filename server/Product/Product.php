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
        $payload = $req->getPayload();

        [
            'sku' => $sku,
            'type' => $type
        ] = $payload;

        $product = new $type($sku, ...$payload);
        
        // initialize object

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

        if ($query->all()) return true;

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