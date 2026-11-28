<?php
class BaseModel {
    protected static string $table = 'base';

    public static function getTableLate(): string {
        return static::$table;
    }

    public static function getTableEarly(): string {
        return self::$table;
    }
}

class User extends BaseModel {
    protected static string $table = 'users';
}

class Order extends BaseModel {
    protected static string $table = 'orders';
}

echo "<h2>Задание 4: Наследование и статика (self:: vs static::)</h2>";

echo "<h3>Использование static:: (позднее связывание)</h3>";
echo "User::getTableLate() возвращает: " . User::getTableLate() . "<br>";
echo "Order::getTableLate() возвращает: " . Order::getTableLate() . "<br><br>";

echo "<h3>Использование self:: (раннее связывание)</h3>";
echo "User::getTableEarly() возвращает: " . User::getTableEarly() . "<br>";
echo "Order::getTableEarly() возвращает: " . Order::getTableEarly() . "<br><br>";

echo "<strong>Вывод:</strong> Ключевое слово <code>static::</code> определяет класс, <em>от имени которого</em> был вызван метод во время выполнения (runtime). Поэтому <code>User::getTableLate()</code> видит переопределённое свойство <code>\$table</code> класса <code>User</code>. 
Ключевое слово <code>self::</code> всегда ссылается на тот класс, <em>в котором</em> метод был физически написан (в данном случае <code>BaseModel</code>), игнорируя переопределения в дочерних классах.";
?>