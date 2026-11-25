<?php

namespace App;

class Electronics extends Product
{
    private float $warrantyPercent;

    public function __construct(string $title, float $price, float $warrantyPercent)
    {
        parent::__construct($title, $price);
        $this->warrantyPercent = $warrantyPercent;
    }

    public function getFinalPrice(): float
    {
        return $this->price * (1 + self::TAX + ($this->warrantyPercent / 100));
    }
}
