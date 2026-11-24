<?php
declare(strict_types=1);

trait JsonExportTrait
{
    public function export(): string
    {
        return json_encode(get_object_vars($this));
    }

    public function getFormat(): string
    {
        return "JSON";
    }
}

trait XmlExportTrait
{
    public function export(): string
    {
        $xml = "<product>";
        foreach (get_object_vars($this) as $key => $value) {
            $xml .= "<{$key}>{$value}</{$key}>";
        }
        $xml .= "</product>";
        return $xml;
    }

    public function getFormat(): string
    {
        return "XML";
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
        return "Product format";
    }
}

$product = new Product("Смартфон", 30000);

echo "JSON-представление: " . $product->export() . PHP_EOL;
echo "XML-представление: " . $product->exportToXml() . PHP_EOL;
echo PHP_EOL;

echo "Основной формат product: " . $product->getFormat() . PHP_EOL;
echo "XML формат: " . $product->getXmlFormat() . PHP_EOL;
echo PHP_EOL;

echo "Цена с налогом 20%: " . $product->getPriceWithTax(20) . " руб." . PHP_EOL;

/* Будет вызвано Product format, а не JSON.
Потому что в классе Product объявлен собственный метод getFormat(). 
По приоритету метод текущего класса переопределяет метод трейта. */