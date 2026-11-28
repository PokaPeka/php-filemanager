<?php
class Cart {
    private array $items;

    public function __construct(array $initialItems = []) {
        $this->items = $initialItems;
        echo "🛒 Корзина создана. Изначально товаров: " . count($this->items) . "<br>";
    }

    public function addItem(string $name, float $price): void {
        if ($price < 0) {
            throw new InvalidArgumentException("Ошибка: цена товара '{$name}' не может быть отрицательной ({$price}).");
        }
        $this->items[$name] = $price;
        echo "Добавлен: {$name} ({$price} руб.)<br>";
    }

    public function removeItem(string $name): void {
        if (isset($this->items[$name])) {
            unset($this->items[$name]);
            echo "Удалён: {$name}<br>";
        } else {
            echo "Товар '{$name}' не найден в корзине.<br>";
        }
    }

    public function getTotal(): float {
        return array_sum($this->items);
    }

    public function __destruct() {
        $count = count($this->items);
        $total = $this->getTotal();
        echo "<br><strong>Корзина закрыта. Товаров: {$count}, сумма: {$total} руб.</strong><br>";
    }
}

echo "<h2>Задание 2: Класс «Корзина товаров»</h2>";

try {
    $cart = new Cart(["Хлеб" => 50.0, "Молоко" => 80.5]);

    $cart->addItem("Сыр", 350.0);
    $cart->addItem("Яблоки", 120.0);

    echo "<br>Попытка добавить товар с отрицательной ценой:<br>";
    $cart->addItem("Брак", -10.0); 

} catch (InvalidArgumentException $e) {
    echo "<span style='color: red;'><strong>Перехвачено исключение:</strong> " . $e->getMessage() . "</span><br>";
}

echo "<br>Удаление товара 'Молоко':<br>";
$cart->removeItem("Молоко");

echo "<br>Текущая сумма корзины: <strong>" . $cart->getTotal() . " руб.</strong><br>";

echo "<hr>Завершение скрипта (сработает деструктор):<br>";
?>