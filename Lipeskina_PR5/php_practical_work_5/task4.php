<?php

$students = [
    ['name' => 'Анна',  'grade' => 4.5],
    ['name' => 'Борис', 'grade' => 3.2],
    ['name' => 'Вера',  'grade' => 4.8],
    ['name' => 'Глеб',  'grade' => 2.9],
];

usort($students, fn(array $a, array $b): int => $b['grade'] <=> $a['grade']);

echo "=== Рейтинг студентов (по убыванию оценки) ===" . PHP_EOL;
foreach ($students as $index => $student) {
    $place = $index + 1;
    echo "{$place}. {$student['name']} — {$student['grade']}" . PHP_EOL;
}

$studentsByName = $students;
usort($studentsByName, fn(array $a, array $b): int => strcmp($a['name'], $b['name']));

echo PHP_EOL . "=== Список студентов по алфавиту ===" . PHP_EOL;
foreach ($studentsByName as $student) {
    echo "{$student['name']} — {$student['grade']}" . PHP_EOL;
}

$greaterThan = fn(float $limit) => fn(array $student): bool => $student['grade'] > $limit;

$topStudents = array_filter($students, $greaterThan(4.0));

echo PHP_EOL . "=== Студенты с оценкой выше 4.0 ===" . PHP_EOL;
foreach ($topStudents as $student) {
    echo "{$student['name']} — {$student['grade']}" . PHP_EOL;
}

echo "Количество студентов с оценкой выше 4.0: " . count($topStudents) . PHP_EOL;
