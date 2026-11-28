<?php
class Product {
    public static int $total = 0;

    public function __construct(private string $name) {
        self::$total++;
    }

    public static function getTotal(): int {
        return self::$total;
    }
}

echo "<h2>Задание 1: Счётчик объектов</h2>";

echo "Создаём 5 товаров...<br>";
$p1 = new Product("Ноутбук");
$p2 = new Product("Смартфон");
$p3 = new Product("Планшет");
$p4 = new Product("Монитор");
$p5 = new Product("Клавиатура");

echo "Всего создано товаров: " . Product::getTotal() . "<br><br>";

echo "Удаляем один объект (unset \$p1)...<br>";
unset($p1);

echo "Всего создано товаров после unset: " . Product::getTotal() . "<br><br>";

echo "<strong>Пояснение:</strong> Значение счётчика не изменилось, потому что статическое свойство <code>\$total</code> хранит историю <em>созданных</em> объектов. Оператор <code>unset()</code> лишь удаляет переменную-ссылку на объект из памяти, но не вызывает автоматического уменьшения статического счётчика. Чтобы счётчик уменьшался, потребовалось бы явно прописать метод <code>__destruct()</code> с <code>self::\$total--</code>, но в условии задачи этого не требовалось.";
?>