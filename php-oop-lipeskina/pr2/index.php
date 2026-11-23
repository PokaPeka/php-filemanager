<?php
declare(strict_types=1);

use Shop\Helpers\PriceFormatter;
use Shop\Models\Customer;
use Shop\Models\Order;
use Shop\Models\Product;
use Shop\Services\Cart;

$manual = in_array('--manual', $argv, true);
if ($manual) {
    require __DIR__ . '/autoload.php';
} else {
    $autoload = __DIR__ . '/vendor/autoload.php';
    if (!is_file($autoload)) {
        fwrite(STDERR, 'Сначала выполните в pr2: composer dump-autoload' . PHP_EOL
            . 'Или запустите: php index.php --manual' . PHP_EOL);
        exit(1);
    }
    require $autoload;
}

echo ($manual ? 'Свой автозагрузчик' : 'Composer') . PHP_EOL;
$customer = new Customer('Анна', 'anna@example.com');
$cart = new Cart($customer);
$cart->add(new Product('Клавиатура', 1250.0), 1);
$cart->add(new Product('Мышь', 750.0), 2);
$cart->add(new Product('Коврик', 350.0), 1);
echo 'Покупатель: ' . $customer->name . PHP_EOL;
echo 'Итого: ' . PriceFormatter::format($cart->getTotal()) . PHP_EOL;

if (in_array('--missing-order', $argv, true)) {
    // Для этого эксперимента временно переименуйте src/Models/Order.php.
    try {
        new Order(1, $cart->getTotal());
        echo 'Order существует. Для проверки ошибки временно переименуйте Order.php.' . PHP_EOL;
    } catch (Error $e) {
        echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    }
} else {
    $order = new Order(1, $cart->getTotal());
    echo "Заказ №{$order->id}: " . PriceFormatter::format($order->total) . PHP_EOL;
}
