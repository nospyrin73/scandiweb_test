<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\Query;

abstract class Product {
    public function __construct(
        protected string $sku,
        protected string $name,
        protected float $price,
        protected string $type
    ) {
    }

    abstract public function insert();

    abstract public function delete();

    public function toMap(): array {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'type' => $this->type
        ];
    }
}