<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\{Database, Query};

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

    public function insert(Database $db): int {
        parent::insert($db);
        
        $query = (new Query($db, $db->tables['Book']))
            ->insert([
                'sku' => '"' . $this->sku . '"',
                'weight' => $this->weight
            ])
            ->execute();

        return $query->getResult()->rowCount();
    }

    public function delete(Database $db): int {
        $q1 = (new Query($db, $db->tables['Book']))
            ->delete()
            ->where()
            ->condition('sku', '=', '"' . $this->sku . '"')
            ->execute();

        $q2 = (new Query($db, $db->tables['Product']))
            ->delete()
            ->where()
            ->condition('sku', '=', '"' . $this->sku . '"')
            ->execute();

        return $q2->getResult()->rowCount();
    }

    public function toMap(): array {
        $map = parent::toMap();

        $map['weight'] = $this->weight;
        
        return $map;
    }
}