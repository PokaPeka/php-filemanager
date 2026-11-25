<?php

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';

    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

use App\Book;
use App\Electronics;
use App\Product;

$catalog = [
    new Book('PHP 8: Объекты, шаблоны и методики', 1500),
    new Book('Чистый код', 1200),
    new Electronics('Ноутбук Ultrabook 14"', 65000, 10),
    new Electronics('Наушники Bluetooth', 4500, 5),
    new Electronics('Смартфон Pro', 42000, 8),
];

$catalogTotal = 0.0;

foreach ($catalog as $item) {
    echo $item->getInfo() . PHP_EOL;
    $catalogTotal += $item->getFinalPrice();
}

echo str_repeat('-', 65) . PHP_EOL;
echo sprintf('Сумма конечных цен по каталогу: %.2f руб.', $catalogTotal) . PHP_EOL;
echo 'Общее число созданных товаров: ' . Product::getCount() . PHP_EOL;
