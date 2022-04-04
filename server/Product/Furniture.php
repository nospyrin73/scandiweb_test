<?php

declare(strict_types = 1);

namespace App\Product;

use App\Database\{Database, Query};

class Furniture extends Product {
    private float $height;

    private float $width;

    private float $length;

    public function __construct(
        string $sku,
        array ...$params

    ) {
        parent::__construct($sku);
        $this->height = (float) $params['height'];
        $this->width = (float) $params['width'];
        $this->length = (float) $params['length'];
    }

    public function getHeight(): float {
        return $this->height;
    }

    public function setHeight(float $height): void {
        $this->height = $height;
    }

    public function getWidth(): float {
        return $this->width;
    }

    public function setWidth(float $width): void {
        $this->width = $width;
    }

    public function getLength(): float {
        return $this->length;
    }

    public function setLength(float $length): void {
        $this->length = $length;
    }

    public function insert(Database $db): int {
        parent::insert($db);
        
        $query = (new Query($db, $db->tables['Furniture']))
            ->insert([
                'sku' => '"' . $this->sku . '"',
                'height' => $this->height,
                'width' => $this->width,
                'length' => $this->length
            ])
            ->execute();

        return $query->getResult()->rowCount();
    }

    public function delete(Database $db): int {
        $q1 = (new Query($db, $db->tables['Furniture']))
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

        $map['height'] = $this->height;
        $map['width'] = $this->width;
        $map['length'] = $this->length;
        
        return $map;
    }
}