<?php

declare(strict_types = 1);

namespace App\Product;

class Furniture extends Product {
    public function __construct(
        string $sku,
        string $name,
        float $price,
        string $type,
        private float $height,
        private float $width,
        private float $length,
    ) {
        parent::__construct($sku, $name, $price, $type);
    }

    public function insert() {

    }

    public function delete() {

    }

    public function toMap(): array {
        $map = parent::toMap();

        $map['height'] = $this->height;
        $map['width'] = $this->width;
        $map['length'] = $this->length;
        
        return $map;
    }
}