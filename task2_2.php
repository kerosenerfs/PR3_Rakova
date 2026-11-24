<?php
declare(strict_types=1);

interface ReportFormatterInterface
{
    public function format(array $data): string;
}

interface ReportHeaderInterface
{
    public const SEPARATOR = "========================";
    public function getHeader(): string;
}

class HtmlFormatter implements ReportFormatterInterface
{
    public function format(array $data): string
    {
        $html = "<ul>" . PHP_EOL;
        foreach ($data as $item) {
            $html .= "  <li>{$item}</li>" . PHP_EOL;
        }
        $html .= "</ul>";
        return $html;
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
        return "Отчёт о продажах за текущий период";
    }

    public function format(array $data): string
    {
        $result = "";
        foreach ($this->sales as $product => $sum) {
            $result .= "Продукт: {$product} — сумма: {$sum} руб." . PHP_EOL;
        }
        return $result;
    }
}

function renderReport(ReportFormatterInterface $report): void
{
    echo $report->format([]) . PHP_EOL;
}

$sales = ['Яблоки' => 1500, 'Груши' => 2300, 'Бананы' => 800];
$salesReport = new SalesReport($sales);

echo "Заголовок отчёта: " . $salesReport->getHeader() . PHP_EOL;
echo ReportHeaderInterface::SEPARATOR . PHP_EOL;

renderReport($salesReport);

echo "Константа SEPARATOR: " . ReportHeaderInterface::SEPARATOR . PHP_EOL . PHP_EOL;