<?php


$square = fn(float $n): float => $n ** 2;
$isEven = fn(int $n): bool => $n % 2 === 0;
$greet  = fn(string $name): string => "Привет, {$name}!";
$max    = fn(float $a, float $b): float => $a >= $b ? $a : $b;

echo "=== Квадрат числа (\$square) ===" . PHP_EOL;
echo "square(4) = " . $square(4) . PHP_EOL;
echo "square(7.5) = " . $square(7.5) . PHP_EOL;

echo PHP_EOL . "=== Проверка чётности (\$isEven) ===" . PHP_EOL;
echo "isEven(10) = " . ($isEven(10) ? 'true' : 'false') . PHP_EOL;
echo "isEven(7) = " . ($isEven(7) ? 'true' : 'false') . PHP_EOL;

echo PHP_EOL . "=== Приветствие (\$greet) ===" . PHP_EOL;
echo $greet('Анна') . PHP_EOL;
echo $greet('Максим') . PHP_EOL;

echo PHP_EOL . "=== Максимум из двух чисел (\$max) ===" . PHP_EOL;
echo "max(12, 25) = " . $max(12, 25) . PHP_EOL;
echo "max(-3, -10) = " . $max(-3, -10) . PHP_EOL;
