<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\Query;

class Book extends Product {
    private float $weight;

    public function __construct(
        string $sku,
    ) {
        parent::__construct($sku);
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight) {
        $this->weight = $weight;
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