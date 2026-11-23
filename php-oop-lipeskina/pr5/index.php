<?php
declare(strict_types=1);

class Employee
{
    private array $salaryHistory = [];

    public function __construct(
        public string $name,
        protected float $baseSalary,
        private string $passport,
    ) {
        if (!is_finite($baseSalary) || $baseSalary < 0) {
            throw new InvalidArgumentException('Оклад должен быть неотрицательным и конечным');
        }
        if (!preg_match('/^[0-9]{10}$/D', $passport)) {
            throw new InvalidArgumentException('Паспорт: 10 цифр без пробелов');
        }
    }

    public function getSalary(): float
    {
        return $this->baseSalary;
    }

    public function raiseSalary(float $percent): void
    {
        $this->validatePercent($percent);
        $oldSalary = $this->baseSalary;
        $this->baseSalary += $this->baseSalary * $percent / 100;
        $this->salaryHistory[] = [
            'old' => $oldSalary,
            'percent' => $percent,
            'new' => $this->baseSalary,
        ];
    }

    final public function getMaskedPassport(): string
    {
        return '**** **' . substr($this->passport, -4);
    }

    public function getSalaryHistory(): array
    {
        return $this->salaryHistory;
    }

    protected function calculateTax(float $amount): float
    {
        return $amount * 0.13;
    }

    private function validatePercent(float $p): void
    {
        if (!is_finite($p) || $p < 1 || $p > 50) {
            throw new InvalidArgumentException('Повышение должно быть от 1 до 50 %');
        }
    }

    public function getNetSalary(): float
    {
        $salary = $this->getSalary();
        return $salary - $this->calculateTax($salary);
    }
}

class Manager extends Employee
{
    public function __construct(string $name, float $baseSalary, string $passport, private int $teamSize)
    {
        parent::__construct($name, $baseSalary, $passport);
        if ($teamSize < 0) {
            throw new InvalidArgumentException('Размер команды не может быть отрицательным');
        }
    }

    public function getSalary(): float
    {
        return $this->baseSalary + 5000 * $this->teamSize;
    }

    public function getNetSalary(): float
    {
        $salary = $this->getSalary();
        return $salary - $this->calculateTax($salary);
    }

    public function demonstrateProtected(): float
    {
        return $this->baseSalary;
    }

    public function demonstratePrivate(): void
    {
        // Недопустимое чтение: echo $this->passport;
        // Выполняем отдельно для эксперимента; значение private родителя не читается.
        echo $this->passport;
    }
}

class Developer extends Employee
{
    public function __construct(string $name, float $baseSalary, string $passport, private string $level)
    {
        parent::__construct($name, $baseSalary, $passport);
        if (!in_array($level, ['junior', 'middle', 'senior'], true)) {
            throw new InvalidArgumentException('Уровень: junior, middle или senior');
        }
    }

    public function getSalary(): float
    {
        $factor = match ($this->level) {
            'junior' => 1.0,
            'middle' => 1.5,
            'senior' => 2.0,
        };
        return $this->baseSalary * $factor;
    }

    public function demonstratePrivateMethod(): void
    {
        // Недопустимый вызов: $this->validatePercent(10);
        $this->validatePercent(10);
    }

    // Запрещено: final-метод родителя нельзя переопределять.
    // public function getMaskedPassport(): string { return 'открытый паспорт'; }
}

if (in_array('--final-error', $argv, true)) {
    // Изолированный эксперимент: завершает только этот запуск с Fatal error.
    eval('class BrokenDeveloper extends Developer { public function getMaskedPassport(): string { return "test"; } }');
    exit;
}

$employee = new Employee('Иван', 50000, '1234563456');
$manager = new Manager('Анна', 70000, '1234567890', 3);
$developer = new Developer('Павел', 60000, '9876543210', 'middle');
$staff = [$employee, $manager, $developer];
echo 'Имя | Тип | До налога | После налога | Паспорт' . PHP_EOL;
foreach ($staff as $person) {
    echo implode(' | ', [
        $person->name,
        $person::class,
        number_format($person->getSalary(), 2, ',', ' '),
        number_format($person->getNetSalary(), 2, ',', ' '),
        $person->getMaskedPassport(),
    ]) . PHP_EOL;
}
echo PHP_EOL . 'Повышение оклада менеджера на 10 %:' . PHP_EOL;
$manager->raiseSalary(10);
echo 'Новая зарплата: ' . $manager->getSalary() . PHP_EOL;
print_r($manager->getSalaryHistory());
try {
    $manager->raiseSalary(51);
} catch (InvalidArgumentException $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . 'Эксперименты доступа:' . PHP_EOL;
$experiments = [
    'Чтение name снаружи' => fn () => $manager->name,
    // Прямые ошибочные строки не нужны в обычном расчёте:
    // echo $manager->baseSalary;
    'Чтение baseSalary снаружи' => fn () => $manager->baseSalary,
    'Чтение baseSalary в Manager' => fn () => $manager->demonstrateProtected(),
    'Чтение passport в Manager' => fn () => $manager->demonstratePrivate(),
    // $manager->calculateTax(1000);
    'Вызов calculateTax снаружи' => fn () => $manager->calculateTax(1000),
    'Вызов validatePercent в Developer' => fn () => $developer->demonstratePrivateMethod(),
];
foreach ($experiments as $title => $experiment) {
    echo $title . ': ';
    // Превращаем предупреждение о недоступном свойстве родителя в исключение.
    set_error_handler(function (int $severity, string $message, string $file, int $line): never {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
    try {
        var_dump($experiment());
    } catch (Throwable $e) {
        echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    } finally {
        restore_error_handler();
    }
}
