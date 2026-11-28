<?php
class Employee {
    public function __construct(
        protected string $name,
        protected float $salary
    ) {}

    public function getInfo(): string {
        return "Сотрудник: {$this->name}, Зарплата: {$this->salary} руб.";
    }

    public function __destruct() {
        echo "Объект сотрудника '{$this->name}' уничтожен.<br>";
    }
}

class Manager extends Employee {
    public function __construct(
        string $name,
        float $salary,
        private string $department
    ) {
        parent::__construct($name, $salary);
    }

    public function getInfo(): string {
        return parent::getInfo() . ", Отдел: {$this->department}";
    }

    public function __destruct() {
        echo "Менеджер <strong>{$this->name}</strong> освобождён от должности.<br>";
    }
}

echo "<h2>Задание 3: Наследование и полиморфизм</h2>";

$staff = [
    new Employee("Олег Сидоров", 60000.0),
    new Manager("Елена Волкова", 120000.0, "Маркетинг"),
    new Employee("Дмитрий Козлов", 55000.0),
    new Manager("Игорь Петров", 150000.0, "Разработка")
];

echo "<h3>Список персонала:</h3><ul>";
foreach ($staff as $person) {
    echo "<li>" . $person->getInfo() . "</li>";
}
echo "</ul>";

echo "<hr>Завершение скрипта. Уничтожение объектов (в порядке, обратном созданию):<br>";
?>