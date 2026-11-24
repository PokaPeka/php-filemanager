<?php
declare(strict_types=1);


class Vehicle
{
    protected string $brand;
    protected int $maxSpeed;

    public function __construct(string $brand, int $maxSpeed)
    {
        $this->brand = $brand;
        $this->maxSpeed = $maxSpeed;
    }

    public function getInfo(): string
    {
        return "Марка: {$this->brand}, макс. скорость: {$this->maxSpeed} км/ч";
    }
}

class Car extends Vehicle
{
    private string $fuelType;

    public function __construct(string $brand, int $maxSpeed, string $fuelType)
    {
        parent::__construct($brand, $maxSpeed);
        $this->fuelType = $fuelType;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . ", тип топлива: {$this->fuelType}";
    }
}

class Airplane extends Vehicle
{
    private int $wingspan;

    public function __construct(string $brand, int $maxSpeed, int $wingspan)
    {
        parent::__construct($brand, $maxSpeed);
        $this->wingspan = $wingspan;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . ", размах крыльев: {$this->wingspan} м";
    }
}

$car = new Car('Toyota Camry', 220, 'бензин');
$airplane = new Airplane('Boeing 737', 850, 35);

$vehicles = [$car, $airplane];

foreach ($vehicles as $vehicle) {
    echo $vehicle->getInfo() . PHP_EOL;
}

echo PHP_EOL;
echo 'Car instanceof Vehicle: ' . var_export($car instanceof Vehicle, true) . PHP_EOL;
echo 'Airplane instanceof Vehicle: ' . var_export($airplane instanceof Vehicle, true) . PHP_EOL;