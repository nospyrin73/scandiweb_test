<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\Query;

class Book extends Product {
    public function __construct(
        string $sku,
        string $name,
        float $price,
        string $type,
        private float $weight
    ) {
        parent::__construct($sku, $name, $price, $type);
    }

    public function insert() {
        
    }

    public function delete() {
        
    }

    public function toMap(): array {
        $map = parent::toMap();

        $map['weight'] = $this->weight;
        
        return $map;
    }
}