<?php

abstract class Employee
{
    public const MIN_BONUS = 500;

    private static int $employeeCount = 0;

    protected string $name;
    protected float $salary;

    public function __construct(string $name, float $salary)
    {
        $this->name = $name;
        $this->salary = $salary;
        self::$employeeCount++;
    }

    abstract public function calculateBonus(): float;

    public function getTotalPayout(): float
    {
        return $this->salary + $this->calculateBonus();
    }

    public function getInfo(): string
    {
        return sprintf(
            '%s (%s): оклад = %.2f руб., премия = %.2f руб.',
            $this->name,
            static::class,
            $this->salary,
            $this->calculateBonus()
        );
    }

    public static function getEmployeeCount(): int
    {
        return self::$employeeCount;
    }
}
