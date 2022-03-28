<?php

declare(strict_types = 1);

namespace App\Product;

class DVD extends Product {
    private float $size;

    public function __construct(
        string $sku
    ) {
        parent::__construct($sku);
    }

    public function getSize(): float {
        return $this->size;
    }

    public function setSize(float $size) {
        $this->size = $size;
    }

    public function insert() {}

    public function delete() {}

    public function toMap(): array {
        $map = parent::toMap();

        $map['size'] = $this->size;

        return $map;
    }
}