<?php
declare(strict_types=1);

interface PaymentInterface
{
    public function pay(float $amount): bool;
    public function refund(float $amount): bool;
    public function getMethodName(): string;
}

class CreditCard implements PaymentInterface
{
    private float $limit;

    public function __construct(float $limit)
    {
        $this->limit = $limit;
    }

    public function pay(float $amount): bool
    {
        if ($amount <= $this->limit) {
            $this->limit -= $amount;
            return true;
        }
        return false;
    }

    public function refund(float $amount): bool
    {
        $this->limit += $amount;
        return true;
    }

    public function getMethodName(): string
    {
        return "Кредитная карта";
    }
}

class PayPal implements PaymentInterface
{
    private float $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }

    public function pay(float $amount): bool
    {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }

    public function refund(float $amount): bool
    {
        $this->balance += $amount;
        return true;
    }

    public function getMethodName(): string
    {
        return "PayPal";
    }
}

class Cash implements PaymentInterface
{
    public function pay(float $amount): bool
    {
        return true;
    }

    public function refund(float $amount): bool
    {
        return true;
    }

    public function getMethodName(): string
    {
        return "Наличные";
    }
}

function checkout(PaymentInterface $method, float $amount): void
{
    $result = $method->pay($amount);
    $status = $result ? "успешно" : "недостаточно средств";
    echo "Оплата {$amount} руб. через {$method->getMethodName()}: {$status}" . PHP_EOL;
}

$card = new CreditCard(1000);
$paypal = new PayPal(500);
$cash = new Cash();

checkout($card, 500);
checkout($paypal, 300);
checkout($cash, 10000);

checkout($card, 800); 
checkout($paypal, 1000); 