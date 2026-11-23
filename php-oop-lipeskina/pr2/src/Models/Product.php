<?php
declare(strict_types=1);

namespace Shop\Models;

class Product
{
    public function __construct(public string $name, public float $price)
    {
        if (!is_finite($price) || $price < 0) {
            throw new \InvalidArgumentException('Цена должна быть неотрицательной и конечной');
        }
    }
}
