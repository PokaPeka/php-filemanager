<?php

class Product
{
    public function __construct(
        private string $title,
        private float $price
    ) {}

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getInfo(): string
    {
        return sprintf('%s — %.2f руб.', $this->title, $this->price);
    }
}
