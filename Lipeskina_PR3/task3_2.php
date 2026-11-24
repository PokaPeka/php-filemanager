<?php
declare(strict_types=1);


trait JsonExportTrait
{
    public function export(): string
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $value) {
            $data[$key] = $value;
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getFormat(): string
    {
        return 'JSON';
    }
}

trait XmlExportTrait
{
    public function export(): string
    {
        $xml = '<product>';
        foreach (get_object_vars($this) as $key => $value) {
            $xml .= "<{$key}>{$value}</{$key}>";
        }
        $xml .= '</product>';
        return $xml;
    }

    public function getFormat(): string
    {
        return 'XML';
    }
}

trait PriceTrait
{
    public function getPriceWithTax(float $tax): float
    {
        return $this->price * (1 + $tax / 100);
    }
}

class Product
{
    use JsonExportTrait, XmlExportTrait, PriceTrait {
        JsonExportTrait::export insteadof XmlExportTrait;
        XmlExportTrait::export as exportToXml;

        JsonExportTrait::getFormat insteadof XmlExportTrait;
        XmlExportTrait::getFormat as getXmlFormat;
    }

    public string $name;
    public float $price;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getFormat(): string
    {
        return 'Product format';
    }
}

$product = new Product('Ноутбук', 75000.00);

echo 'JSON: ' . $product->export() . PHP_EOL;
echo 'XML:  ' . $product->exportToXml() . PHP_EOL;
echo PHP_EOL;

echo 'getFormat()     (метод класса): ' . $product->getFormat() . PHP_EOL;
echo 'getXmlFormat()  (псевдоним):    ' . $product->getXmlFormat() . PHP_EOL;
echo PHP_EOL;

echo 'Цена с налогом 20%: ' . number_format($product->getPriceWithTax(20), 2, '.', ' ') . ' руб.' . PHP_EOL;