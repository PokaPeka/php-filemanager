<?php

class Order
{
    /**
     * @param Product[] $products
     */
    public function __construct(
        private User $user,
        private array $products
    ) {}

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }
}
