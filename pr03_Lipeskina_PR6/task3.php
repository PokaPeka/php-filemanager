<?php
trait LoggableTrait {
    private array $logs = [];

    public function log(string $message): void {
        $this->logs[] = date('Y-m-d H:i:s') . " - " . $message;
    }

    public function printLogs(): void {
        echo "<pre>" . implode("\n", $this->logs) . "</pre>";
    }
}

trait Timestampable {
    private ?string $createdAt = null;

    public function setCreatedAt(): void {
        $this->createdAt = date('Y-m-d H:i:s');
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }
}

class Order {
    use LoggableTrait, Timestampable;

    public function __construct(private string $item) {
        $this->setCreatedAt();
        $this->log("Создан заказ: {$item}");
    }
}

class User {
    use LoggableTrait;

    public function __construct(private string $name) {
        $this->log("Пользователь {$name} зарегистрирован.");
    }
}

echo "<h2>Задание 3: Трейты</h2>";

echo "<h3>Заказ:</h3>";
$order = new Order("Ноутбук ASUS");
echo "Время создания заказа: " . $order->getCreatedAt() . "<br>";
$order->printLogs();

echo "<h3>Пользователь:</h3>";
$user = new User("Иван Иванов");
$user->printLogs();
?>