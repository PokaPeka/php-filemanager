<?php
declare(strict_types=1);

interface PaymentInterface
{
    public function pay(float $amount): bool;
    public function refund(float $amount): bool;
    public function getMethodName(): string;
}

class CreditCard implements PaymentInterface
{
    private float $limit;

    public function __construct(float $limit)
    {
        $this->limit = $limit;
    }

    public function pay(float $amount): bool
    {
        return $amount <= $this->limit;
    }

    public function refund(float $amount): bool
    {
        return $amount <= $this->limit;
    }

    public function getMethodName(): string
    {
        return 'Кредитная карта';
    }
}

class PayPal implements PaymentInterface
{
    private float $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }

    public function pay(float $amount): bool
    {
        if ($amount > $this->balance) {
            return false;
        }
        $this->balance -= $amount;
        return true;
    }

    public function refund(float $amount): bool
    {
        $this->balance += $amount;
        return true;
    }

    public function getMethodName(): string
    {
        return 'PayPal';
    }
}

class Cash implements PaymentInterface
{
    public function pay(float $amount): bool
    {
        return true;
    }

    public function refund(float $amount): bool
    {
        return true;
    }

    public function getMethodName(): string
    {
        return 'Наличные';
    }
}

function checkout(PaymentInterface $method, float $amount): void
{
    $name = $method->getMethodName();
    $success = $method->pay($amount);

    if ($success) {
        echo "[{$name}] Оплата {$amount} руб. — УСПЕШНО" . PHP_EOL;
    } else {
        echo "[{$name}] Оплата {$amount} руб. — ОТКАЗАНО" . PHP_EOL;
    }
}

$card = new CreditCard(5000);
$paypal = new PayPal(1000);
$cash = new Cash();

echo "=== Успешные оплаты ===" . PHP_EOL;
checkout($card, 3000);
checkout($paypal, 500);
checkout($cash, 10000);

echo PHP_EOL . "=== Неуспешные оплаты ===" . PHP_EOL;
checkout($card, 6000); 
checkout($paypal, 2000); 