<?php

declare(strict_types = 1);

namespace App\Product;

class Furniture extends Product {
    private float $height;

    private float $width;

    private float $length;

    public function __construct(
        string $sku,
    ) {
        parent::__construct($sku);
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