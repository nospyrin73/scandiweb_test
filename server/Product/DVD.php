<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\{Database, Query};

class DVD extends Product {
    private float $size;

    public function __construct(
        string $sku,
        array ...$params
    ) {
        parent::__construct($sku);
        $this->size = (float) $params['size'];
    }

    public function getSize(): float {
        return $this->size;
    }

    public function setSize(float $size) {
        $this->size = $size;
    }

    public function insert(Database $db): int {
        parent::insert($db);

        $query = (new Query($db, $db->tables['DVD']))
            ->insert([
                'sku' => '"' . $this->sku . '"',
                'size' => (float) $this->size
            ])
            ->execute();

        return $query->getResult()->rowCount();
    }

    public function delete(Database $db): int {
        $q1 = (new Query($db, $db->tables['DVD']))
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

        $map['size'] = $this->size;

        return $map;
    }
}