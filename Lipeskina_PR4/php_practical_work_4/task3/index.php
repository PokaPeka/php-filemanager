<?php

spl_autoload_register(function (string $class): void {
    $path = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

$shapes = [
    new Circle(5),
    new Rectangle(4, 7),
    new Triangle(3, 4, 5),
];

foreach ($shapes as $shape) {
    echo $shape->describe() . PHP_EOL;
}

/*
 * Попытка создать объект абстрактного класса приведёт к фатальной ошибке:
 * Fatal error: Uncaught Error: Cannot instantiate abstract class Shape
 *
 * $shape = new Shape();
 *
 * Причина: абстрактный класс — это незавершённая заготовка (контракт),
 * в которой у абстрактных методов нет реализации. Создавать можно
 * только экземпляры конкретных классов-наследников, реализовавших все методы.
 */
