<?php
interface Loggable {
    public function log(string $message): void;
    public function getLogs(): array;
}

interface Storable {
    public function save(): bool;
    public function load(int $id): mixed;
}

class Article implements Loggable, Storable {
    private array $logs = [];

    public function __construct(public string $title, public string $text) {}

    public function log(string $message): void {
        $this->logs[] = date('Y-m-d H:i:s') . " - " . $message;
    }

    public function getLogs(): array {
        return $this->logs;
    }

    public function save(): bool {
        $this->log("Статья '{$this->title}' сохранена.");
        return true;
    }

    public function load(int $id): mixed {
        $this->log("Попытка загрузки статьи с ID: $id (заглушка).");
        return "Данные статьи с ID $id";
    }
}

function process(Storable $item): void {
    echo "Обработка объекта: ";
    $item->save();
}

echo "<h2>Задание 2: Несколько интерфейсов</h2>";
$article = new Article("Изучаем PHP", "Трейты и интерфейсы - это мощно.");

$article->log("Статья создана.");
$article->save();
$article->load(42);

echo "<h3>Логи статьи:</h3><pre>";
print_r($article->getLogs());
echo "</pre>";

echo "<h3>Проверка бонусной функции process():</h3>";
process($article);
?>