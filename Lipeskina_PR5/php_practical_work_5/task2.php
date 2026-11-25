<?php


$discount = 0.9; // скидка 10%
$applyDiscount = fn(float $price): float => $price * $discount;

echo "=== До изменения \$discount (скидка 10%, коэффициент 0.9) ===" . PHP_EOL;
echo "1000 руб. -> " . $applyDiscount(1000) . " руб." . PHP_EOL;
echo "2500 руб. -> " . $applyDiscount(2500) . " руб." . PHP_EOL;
echo "450 руб.  -> " . $applyDiscount(450) . " руб." . PHP_EOL;

$discount = 0.5;

echo PHP_EOL . "=== После изменения \$discount на 0.5 ===" . PHP_EOL;
echo "1000 руб. -> " . $applyDiscount(1000) . " руб." . PHP_EOL;
echo "2500 руб. -> " . $applyDiscount(2500) . " руб." . PHP_EOL;

$rate = 92.5; 
$toRubles = fn(float $priceInCurrency): float => round($priceInCurrency * $discount * $rate, 2);

echo PHP_EOL . "=== Конвертация в рубли с учётом текущих \$discount (0.5) и \$rate (92.5) ===" . PHP_EOL;
echo "100 у.е. -> " . $toRubles(100) . " руб." . PHP_EOL;
echo "250 у.е. -> " . $toRubles(250) . " руб." . PHP_EOL;
