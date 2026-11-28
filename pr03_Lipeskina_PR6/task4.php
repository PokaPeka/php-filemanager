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

trait JsonExporter {
    public function describe(): string {
        return json_encode(['format' => 'JSON', 'status' => 'ready']);
    }
}

trait XmlExporter {
    public function describe(): string {
        return "<Report><format>XML</format><status>ready</status></Report>";
    }
}

class Report {
    use JsonExporter, XmlExporter {
        JsonExporter::describe insteadof XmlExporter; 
        XmlExporter::describe as describeAsXml;       
    }
}

trait CrudOperations {
    use LoggableTrait; 

    public function create(string $name): void {
        $this->log("Создан новый продукт: {$name}");
    }

    public function delete(int $id): void {
        $this->log("Удален продукт с ID: {$id}");
    }
}

class Product {
    use CrudOperations;

    public function __construct(private string $name) {
        $this->create($this->name);
    }
}

echo "<h2>Задание 4: Конфликт трейтов и композиция</h2>";

echo "<h3>Часть А: Отчет (Report)</h3>";
$report = new Report();
echo "Метод по умолчанию (JSON): " . $report->describe() . "<br>";
echo "Метод с алиасом (XML): " . $report->describeAsXml() . "<br>";

echo "<h3>Часть Б: Продукт (Product) с CRUD и Логированием</h3>";
$product = new Product("Смартфон");
$product->delete(105);
echo "Логи продукта:<br>";
$product->printLogs();
?>