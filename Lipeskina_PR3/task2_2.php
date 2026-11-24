<?php
declare(strict_types=1);

interface ReportFormatterInterface
{
    public function format(array $data): string;
}

interface ReportHeaderInterface
{
    public const SEPARATOR = '=';

    public function getHeader(): string;
}

class HtmlFormatter implements ReportFormatterInterface
{
    public function format(array $data): string
    {
        $items = '';
        foreach ($data as $item) {
            $items .= "<li>{$item}</li>";
        }
        return "<ul>{$items}</ul>";
    }
}

class CsvFormatter implements ReportFormatterInterface
{
    public function format(array $data): string
    {
        return implode(';', $data);
    }
}

class SalesReport implements ReportFormatterInterface, ReportHeaderInterface
{
    private array $sales;

    public function __construct(array $sales)
    {
        $this->sales = $sales;
    }

    public function getHeader(): string
    {
        return 'Отчёт о продажах за текущий период';
    }

    public function format(array $data): string
    {
        $lines = [];
        foreach ($data as $product => $amount) {
            $lines[] = "Продукт: {$product} — сумма: {$amount} руб.";
        }
        return implode(PHP_EOL, $lines);
    }

    public function getSales(): array
    {
        return $this->sales;
    }
}

function renderReport(ReportFormatterInterface $report): void
{
    $data = $report instanceof SalesReport ? $report->getSales() : [];
    echo $report->format($data) . PHP_EOL;
}

$salesReport = new SalesReport([
    'Хлеб' => 50,
    'Молоко' => 80,
    'Сыр' => 300,
]);

echo $salesReport->getHeader() . PHP_EOL;
echo ReportHeaderInterface::SEPARATOR . PHP_EOL;
renderReport($salesReport);

echo PHP_EOL . 'Значение константы SEPARATOR: ' . ReportHeaderInterface::SEPARATOR . PHP_EOL;

echo PHP_EOL . 'HtmlFormatter: ' . (new HtmlFormatter())->format(['A', 'B', 'C']) . PHP_EOL;
echo 'CsvFormatter: ' . (new CsvFormatter())->format(['A', 'B', 'C']) . PHP_EOL;