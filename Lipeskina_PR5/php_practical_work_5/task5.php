<?php


$orders = [
    ['id' => 1, 'customer' => 'Иван',  'total' => 1200, 'status' => 'done'],
    ['id' => 2, 'customer' => 'Мария', 'total' => 800,  'status' => 'new'],
    ['id' => 3, 'customer' => 'Пётр',  'total' => 3500, 'status' => 'done'],
    ['id' => 4, 'customer' => 'Анна',  'total' => 600,  'status' => 'cancelled'],
    ['id' => 5, 'customer' => 'Олег',  'total' => 2100, 'status' => 'done'],
];

$doneOrders = array_filter($orders, fn(array $o): bool => $o['status'] === 'done');
$revenue = array_reduce($doneOrders, fn(float $sum, array $o): float => $sum + $o['total'], 0.0);

$bigOrders = array_filter($orders, fn(array $o): bool => $o['total'] > 1000);
$bigOrderLines = array_map(
    fn(array $o): string => "Заказ №{$o['id']} — {$o['total']} руб. ({$o['customer']})",
    $bigOrders
);

$sortedDone = array_values($doneOrders);
usort($sortedDone, fn(array $a, array $b): int => $b['total'] <=> $a['total']);
$mostExpensiveDone = $sortedDone[0] ?? null;

$uniqueCustomers = array_values(array_unique(
    array_map(fn(array $o): string => $o['customer'], $orders)
));

$cancelledOrders = array_filter($orders, fn(array $o): bool => $o['status'] === 'cancelled');

echo "=== ОТЧЁТ ПО ЗАКАЗАМ ===" . PHP_EOL . PHP_EOL;

echo "1. Выручка по выполненным заказам (done): {$revenue} руб." . PHP_EOL . PHP_EOL;

echo "2. Заказы на сумму свыше 1000 руб.:" . PHP_EOL;
foreach ($bigOrderLines as $line) {
    echo "   - {$line}" . PHP_EOL;
}

echo PHP_EOL . "3. Самый дорогой выполненный заказ:" . PHP_EOL;
if ($mostExpensiveDone !== null) {
    echo "   Заказ №{$mostExpensiveDone['id']} — {$mostExpensiveDone['total']} руб. ({$mostExpensiveDone['customer']})" . PHP_EOL;
}

echo PHP_EOL . "4. Клиенты (без дубликатов):" . PHP_EOL;
echo "   " . implode(', ', $uniqueCustomers) . PHP_EOL;

echo PHP_EOL . "5. Итоговая статистика:" . PHP_EOL;
echo "   Всего заказов:    " . count($orders) . PHP_EOL;
echo "   Выполнено:        " . count($doneOrders) . PHP_EOL;
echo "   Отменено:         " . count($cancelledOrders) . PHP_EOL;
echo "   Сумма выручки:    {$revenue} руб." . PHP_EOL;
