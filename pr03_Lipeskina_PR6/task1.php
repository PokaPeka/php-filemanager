<?php
interface Shape {
    public function area(): float;
    public function perimeter(): float;
}

class Rectangle implements Shape {
    public function __construct(private float $a, private float $b) {}

    public function area(): float { 
        return $this->a * $this->b; 
    }
    
    public function perimeter(): float { 
        return 2 * ($this->a + $this->b); 
    }
}
class Circle implements Shape {
    public function __construct(private float $radius) {}

    public function area(): float { 
        return M_PI * pow($this->radius, 2); 
    }
    
    public function perimeter(): float { 
        return 2 * M_PI * $this->radius; 
    }
}

$shapes = [
    new Rectangle(5.0, 10.0),
    new Circle(7.0),
    new Rectangle(3.5, 4.2),
    new Circle(2.5)
];

echo "<h2>Задание 1: Полиморфизм через интерфейс Shape</h2>";
foreach ($shapes as $index => $shape) {
    $className = get_class($shape);
    echo "Фигура #" . ($index + 1) . " ($className):<br>";
    echo "Площадь: " . round($shape->area(), 2) . "<br>";
    echo "Периметр: " . round($shape->perimeter(), 2) . "<hr>";
}
?>