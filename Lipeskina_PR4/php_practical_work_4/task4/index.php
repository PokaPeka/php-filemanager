<?php

spl_autoload_register(function (string $class): void {
    $path = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

$employees = [
    new Manager('Анна Смирнова', 60000),
    new Manager('Олег Петров', 2000), // Проверка срабатывания MIN_BONUS
    new Developer('Дмитрий Иванов', 90000, 4),
    new Developer('Елена Козлова', 120000, 7),
    new Developer('Максим Сидоров', 70000, 1),
];

$totalPayouts = 0.0;

foreach ($employees as $employee) {
    echo $employee->getInfo() . PHP_EOL;
    $totalPayouts += $employee->getTotalPayout();
}

echo str_repeat('-', 50) . PHP_EOL;
echo sprintf('Общая сумма выплат (оклад + премия): %.2f руб.', $totalPayouts) . PHP_EOL;
echo 'Всего сотрудников: ' . Employee::getEmployeeCount() . PHP_EOL;
