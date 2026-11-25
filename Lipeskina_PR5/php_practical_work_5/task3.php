<?php

$products = [
    ['title' => 'Книга',    'price' => 500],
    ['title' => 'Рюкзак',   'price' => 2500],
    ['title' => 'Кружка',   'price' => 350],
    ['title' => 'Наушники', 'price' => 4200],
    ['title' => 'Блокнот',  'price' => 150],
];

$formatted = array_map(
    fn(array $p): string => "{$p['title']} — {$p['price']} руб.",
    $products
);

echo "=== Все товары ===" . PHP_EOL;
echo implode(PHP_EOL, $formatted) . PHP_EOL;

$expensive = array_filter(
    $products,
    fn(array $p): bool => $p['price'] > 1000
);
$expensiveTitles = array_map(
    fn(array $p): string => $p['title'],
    $expensive
);

echo PHP_EOL . "=== Товары дороже 1000 руб. ===" . PHP_EOL;
echo implode(', ', $expensiveTitles) . PHP_EOL;

$totalPrice = array_reduce(
    $products,
    fn(float $sum, array $p): float => $sum + $p['price'],
    0.0
);

echo PHP_EOL . "=== Общая стоимость всех товаров ===" . PHP_EOL;
echo "Итого: {$totalPrice} руб." . PHP_EOL;

$discountedProducts = array_map(
    fn(array $p): array => [
        'title' => $p['title'],
        'price' => round($p['price'] * 0.85, 2),
    ],
    $products
);
$discountedLines = array_map(
    fn(array $p): string => "{$p['title']} — {$p['price']} руб.",
    $discountedProducts
);

echo PHP_EOL . "=== Товары со скидкой 15% ===" . PHP_EOL;
echo implode(PHP_EOL, $discountedLines) . PHP_EOL;
