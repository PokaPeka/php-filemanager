<?php
declare(strict_types=1);


trait LoggerTrait
{
    protected array $logs = [];

    public function log(string $message): void
    {
        $this->logs[] = '[' . date('Y-m-d H:i:s') . '] ' . $message;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    public function clearLogs(): void
    {
        $this->logs = [];
    }
}

class UserService
{
    use LoggerTrait;

    public function register(string $username): void
    {
        $this->log("Зарегистрирован пользователь: {$username}");
    }
}

class OrderService
{
    use LoggerTrait;

    public function createOrder(int $orderId, float $total): void
    {
        $this->log("Создан заказ №{$orderId} на сумму {$total} руб.");
    }
}

$userSvc = new UserService();
$orderSvc = new OrderService();

$userSvc->register('alice');
$userSvc->register('bob');
$orderSvc->createOrder(1001, 2500.50);
$orderSvc->createOrder(1002, 780.00);

echo "=== Журнал UserService ===" . PHP_EOL;
foreach ($userSvc->getLogs() as $line) {
    echo $line . PHP_EOL;
}

echo PHP_EOL . "=== Журнал OrderService ===" . PHP_EOL;
foreach ($orderSvc->getLogs() as $line) {
    echo $line . PHP_EOL;
}

$userSvc->clearLogs();

echo PHP_EOL . "=== После очистки UserService ===" . PHP_EOL;
echo 'UserService logs count: ' . count($userSvc->getLogs()) . PHP_EOL;
echo 'OrderService logs count: ' . count($orderSvc->getLogs()) . PHP_EOL;
echo '(журнал OrderService остался нетронутым)' . PHP_EOL;