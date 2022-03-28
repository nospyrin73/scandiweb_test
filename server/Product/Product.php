<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\Query;

abstract class Product {
    protected string $name;

    protected float $price;

    protected string $type;

    public function __construct(
        protected string $sku,
    ) {
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    public function setType(string $type) {
        $this->type = $type;
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