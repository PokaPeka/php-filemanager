<?php
declare(strict_types=1);

class Student
{
    public const MIN_COURSE = 1;
    public const MAX_COURSE = 4;
    public static int $totalStudents = 0;
    public static string $university = 'Учебный университет';

    public ?string $email = null;
    public array $grades = [];
    public bool $isActive = true;
    private array $history = [];

    public function __construct(
        public readonly int $id,
        public string $lastName,
        public string $firstName,
        public int $course,
    ) {
        if ($course < self::MIN_COURSE || $course > self::MAX_COURSE) {
            throw new InvalidArgumentException('Курс должен быть от 1 до 4');
        }
        self::$totalStudents++;
    }

    public function getAverageGrade(): ?float
    {
        return $this->grades === [] ? null : array_sum($this->grades) / count($this->grades);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->history[] = $name;
        echo "Предупреждение: запись в недоступное или несуществующее свойство '$name' запрещена" . PHP_EOL;
    }

    public function getHistory(): array
    {
        return $this->history;
    }
}

$students = [
    new Student(1001, 'Иванов', 'Иван', 1),
    new Student(1002, 'Петрова', 'Анна', 2),
    new Student(1003, 'Сидоров', 'Павел', 3),
    new Student(1004, 'Смирнова', 'Мария', 4),
];
$gradeSets = [[5, 4, 5], [5, 5, 5], [3, 4, 4], [4, 5, 4]];
foreach ($students as $i => $student) {
    $student->grades = $gradeSets[$i];
    if ($i !== 2) {
        $student->email = 'student' . ($i + 1) . '@example.com';
    }
}
echo 'Билет | ФИО | Курс | Почта | Средний балл' . PHP_EOL;
foreach ($students as $student) {
    $average = $student->getAverageGrade();
    echo implode(' | ', [
        $student->id,
        "$student->lastName $student->firstName",
        $student->course,
        $student->email ?? 'не указана',
        $average === null ? 'нет оценок' : number_format($average, 2, ',', ''),
    ]) . PHP_EOL;
}
echo 'Всего студентов: ' . Student::$totalStudents . PHP_EOL;

$student = $students[0];
echo PHP_EOL . '1. Изменение readonly id:' . PHP_EOL;
try {
    $student->id = 9999;
} catch (Error $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
echo PHP_EOL . '2. Строка в course:' . PHP_EOL;
try {
    $student->course = '2';
} catch (TypeError $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
echo PHP_EOL . '3. Курс 7:' . PHP_EOL;
try {
    new Student(1005, 'Тестов', 'Тест', 7);
} catch (InvalidArgumentException $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
echo 'Счётчик после неудачного создания: ' . Student::$totalStudents . PHP_EOL;
echo PHP_EOL . '4. Изменение общего университета:' . PHP_EOL;
echo 'Было: ' . Student::$university . PHP_EOL;
Student::$university = 'Новый университет';
foreach ($students as $s) {
    echo $s->id . ': ' . $s::$university . PHP_EOL;
}
echo PHP_EOL . '5. var_dump:' . PHP_EOL;
var_dump($student);
echo 'get_object_vars снаружи класса:' . PHP_EOL;
var_dump(get_object_vars($student));
echo PHP_EOL . 'Дополнительно: __set:' . PHP_EOL;
$student->nickname = 'test';
echo 'История: ' . implode(', ', $student->getHistory()) . PHP_EOL;
echo 'Динамическое свойство создано: ';
var_dump(property_exists($student, 'nickname'));
