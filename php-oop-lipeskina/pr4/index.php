<?php
declare(strict_types=1);

class QueryBuilder
{
    private string $tableName;
    private array $columns = ['*'];
    private array $conditions = [];
    private array $sorting = [];
    private ?int $rowLimit = null;

    public static function table(string $name): static
    {
        self::validateIdentifier($name);
        $query = new static();
        $query->tableName = $name;
        return $query;
    }

    public function select(string ...$columns): static
    {
        foreach ($columns as $column) {
            self::validateIdentifier($column, true);
        }
        $this->columns = $columns === [] ? ['*'] : $columns;
        return $this;
    }

    public function where(string $column, string $operator, string|int $value): static
    {
        self::validateIdentifier($column);
        if (!in_array($operator, ['=', '!=', '>', '<', '>=', '<=', 'LIKE'], true)) {
            throw new InvalidArgumentException('Недопустимый оператор: ' . $operator);
        }
        $this->conditions[] = "$column $operator " . $this->quote($value);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        self::validateIdentifier($column);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Направление должно быть ASC или DESC');
        }
        $this->sorting[] = "$column $direction";
        return $this;
    }

    public function limit(int $count): static
    {
        if ($count <= 0) {
            throw new InvalidArgumentException('LIMIT должен быть больше 0');
        }
        $this->rowLimit = $count;
        return $this;
    }

    public function toSql(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->columns) . ' FROM ' . $this->tableName;
        if ($this->conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $this->conditions);
        }
        if ($this->sorting !== []) {
            $sql .= ' ORDER BY ' . implode(', ', $this->sorting);
        }
        if ($this->rowLimit !== null) {
            $sql .= ' LIMIT ' . $this->rowLimit;
        }
        return $sql;
    }

    public function __toString(): string
    {
        return $this->toSql();
    }

    private function quote(string|int $value): string
    {
        return is_int($value) ? (string) $value : "'" . str_replace("'", "''", $value) . "'";
    }

    private static function validateIdentifier(string $name, bool $allowStar = false): void
    {
        if ($allowStar && $name === '*') {
            return;
        }
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/D', $name)) {
            throw new InvalidArgumentException('Недопустимое имя таблицы или поля: ' . $name);
        }
    }

    public function __call(string $name, array $arguments): static
    {
        if (!preg_match('/^where([A-Z][a-zA-Z0-9]*)$/D', $name, $matches)
            || count($arguments) !== 1) {
            throw new BadMethodCallException('Неизвестный метод или неверное число аргументов: ' . $name);
        }
        return $this->where(lcfirst($matches[1]), '=', $arguments[0]);
    }
}

echo QueryBuilder::table('users')
    ->select('id', 'name', 'email')
    ->where('age', '>=', 18)
    ->where('city', '=', 'Москва')
    ->orderBy('name')
    ->limit(10) . PHP_EOL;

echo QueryBuilder::table('products')
    ->where('price', '<', 5000)
    ->orderBy('price', 'DESC')
    ->limit(5) . PHP_EOL;

echo QueryBuilder::table('books')->select('title', 'author')
    ->where('author', 'LIKE', "O'Reilly%") . PHP_EOL;

echo QueryBuilder::table('users')->whereCity('Москва')->limit(3) . PHP_EOL;
echo QueryBuilder::table('logs')->select()->toSql() . PHP_EOL;

$experiments = [
    'Неверная сортировка' => fn () => QueryBuilder::table('users')->orderBy('name', 'UP'),
    'Неверный LIMIT' => fn () => QueryBuilder::table('users')->limit(0),
    'Неверный оператор' => fn () => QueryBuilder::table('users')->where('age', '==', 18),
    'Неверное имя' => fn () => QueryBuilder::table('users; DROP TABLE users'),
    'Неизвестный метод' => fn () => QueryBuilder::table('users')->unknown(),
];
foreach ($experiments as $title => $experiment) {
    try {
        $experiment();
    } catch (InvalidArgumentException | BadMethodCallException $e) {
        echo "$title: " . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    }
}
