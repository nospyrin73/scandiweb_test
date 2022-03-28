<?php

declare(strict_types = 1);

namespace App\Product;

class DVD extends Product {
    public function __construct(
        string $sku,
        string $name,
        float $price,
        string $type,
        private float $size
    ) {
        parent::__construct($sku, $name, $price, $type);
    }

    public function insert() {}

    public function delete() {}

    public function toMap(): array {
        $map = parent::toMap();

        $map['size'] = $this->size;

        return $map;
    }
}