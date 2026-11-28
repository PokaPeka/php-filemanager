<?php
class MathHelper {
    public static float $pi = 3.14159;

    public static function add(float $a, float $b): float {
        return $a + $b;
    }

    public static function subtract(float $a, float $b): float {
        return $a - $b;
    }

    public static function multiply(float $a, float $b): float {
        return $a * $b;
    }

    public static function divide(float $a, float $b): float {
        if ($b === 0.0) {
            throw new DivisionByZeroError("Деление на ноль невозможно!");
        }
        return $a / $b;
    }

    public static function circleArea(float $r): float {
        return self::$pi * ($r ** 2);
    }
}

echo "<h2>Задание 2: Математический калькулятор</h2>";

echo "Сложение (10 + 5): " . MathHelper::add(10, 5) . "<br>";
echo "Вычитание (10 - 5): " . MathHelper::subtract(10, 5) . "<br>";
echo "Умножение (10 * 5): " . MathHelper::multiply(10, 5) . "<br>";

echo "Деление (10 / 2): " . MathHelper::divide(10, 2) . "<br>";

echo "Деление (10 / 0): ";
try {
    echo MathHelper::divide(10, 0);
} catch (DivisionByZeroError $e) {
    echo "<span style='color:red;'>" . $e->getMessage() . "</span>";
}
echo "<br>";

echo "Значение PI: " . MathHelper::$pi . "<br>";
echo "Площадь круга (радиус 2): " . MathHelper::circleArea(2) . "<br>";
?>