<?php
declare(strict_types=1);


abstract class Employee
{
    protected string $name;
    protected float $baseSalary;

    public function __construct(string $name, float $baseSalary)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
    }

    abstract public function calculateSalary(): float;

    public function getName(): string
    {
        return $this->name;
    }
}

class Manager extends Employee
{
    public function calculateSalary(): float
    {
        return $this->baseSalary * 1.20;
    }
}

class Developer extends Employee
{
    private int $overtimeHours = 0;

    public function setOvertimeHours(int $hours): void
    {
        $this->overtimeHours = $hours;
    }

    public function calculateSalary(): float
    {
        return $this->baseSalary + $this->overtimeHours * 500;
    }
}

class Intern extends Employee
{
    public function calculateSalary(): float
    {
        return $this->baseSalary * 0.50;
    }
}

function printPayroll(array $employees): void
{
    echo str_pad('Имя', 20) . ' | Зарплата' . PHP_EOL;
    echo str_repeat('-', 35) . PHP_EOL;

    $total = 0.0;
    foreach ($employees as $emp) {
        $salary = $emp->calculateSalary();
        $total += $salary;
        echo str_pad($emp->getName(), 20) . ' | ' . number_format($salary, 2, '.', ' ') . ' руб.' . PHP_EOL;
    }

    echo str_repeat('-', 35) . PHP_EOL;
    echo str_pad('ИТОГО (ФОТ):', 20) . ' | ' . number_format($total, 2, '.', ' ') . ' руб.' . PHP_EOL;
}

$manager = new Manager('Иван Петров', 80000);
$developer = new Developer('Ольга Сидорова', 120000);
$developer->setOvertimeHours(10);
$intern = new Intern('Алексей Новиков', 40000);

printPayroll([$manager, $developer, $intern]);