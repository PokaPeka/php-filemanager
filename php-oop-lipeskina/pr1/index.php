<?php
declare(strict_types=1);

class Book
{
    public function __construct(
        public string $title,
        public string $author,
        public int $year,
        public int $pages,
    ) {}

    public function getInfo(): string
    {
        return "{$this->title} — {$this->author}, {$this->year}, {$this->pages} стр.";
    }

    public function getAge(): int
    {
        return (int) date('Y') - $this->year;
    }
}

class Library
{
    /** @var Book[] */
    private array $books = [];

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    public function findByAuthor(string $author): array
    {
        return array_values(array_filter(
            $this->books,
            fn (Book $book): bool => $book->author === $author,
        ));
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function printAll(): void
    {
        foreach ($this->books as $book) {
            echo $book->getInfo() . PHP_EOL;
        }
    }

    public function getOldest(): ?Book
    {
        $oldest = null;
        foreach ($this->books as $book) {
            if ($oldest === null || $book->year < $oldest->year) {
                $oldest = $book;
            }
        }
        return $oldest;
    }
}

$library = new Library();
$b1 = new Book('Мастер и Маргарита', 'М. Булгаков', 1967, 480);
$books = [
    $b1,
    new Book('Собачье сердце', 'М. Булгаков', 1987, 192),
    new Book('Война и мир', 'Л. Толстой', 1869, 1225),
    new Book('Преступление и наказание', 'Ф. Достоевский', 1866, 672),
    new Book('Капитанская дочка', 'А. Пушкин', 1836, 320),
];
foreach ($books as $book) {
    $library->addBook($book);
}
echo 'Все книги:' . PHP_EOL;
$library->printAll();
echo PHP_EOL . 'Поиск: М. Булгаков' . PHP_EOL;
foreach ($library->findByAuthor('М. Булгаков') as $book) {
    echo $book->getInfo() . PHP_EOL;
}
echo 'Количество: ' . $library->count() . PHP_EOL;
echo 'Возраст первой книги: ' . $b1->getAge() . PHP_EOL;
echo 'Самая старая: ' . $library->getOldest()?->getInfo() . PHP_EOL;
echo 'Пустая библиотека: ';
var_dump((new Library())->getOldest());
echo 'Первая книга — Book: ';
var_dump($b1 instanceof Book);

$b2 = $b1;
$b3 = clone $b1;
$b1->title = 'Изменённое название';
echo PHP_EOL . 'Присваивание и клонирование:' . PHP_EOL;
foreach (['b1' => $b1, 'b2' => $b2, 'b3' => $b3] as $name => $book) {
    echo '$' . $name . ': ' . $book->getInfo() . PHP_EOL;
}
echo '$b1 === $b2: ';
var_dump($b1 === $b2);
echo '$b1 === $b3: ';
var_dump($b1 === $b3);
