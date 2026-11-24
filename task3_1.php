<?php
declare(strict_types=1);

trait LoggerTrait
{
    private array $logs = [];

    public function log(string $message): void
    {
        $date = date('Y-m-d H:i:s');
        $this->logs[] = "[{$date}] {$message}";
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    public function clearLogs(): void
    {
        $this->logs = [];
    }
}

class UserService
{
    use LoggerTrait;

    public function register(string $username): void
    {
        $this->log("Зарегистрирован пользователь: {$username}");
    }
}

class OrderService
{
    use LoggerTrait;

    public function createOrder(int $orderId, float $total): void
    {
        $this->log("Создан заказ №{$orderId} на сумму {$total} руб.");
    }
}

$userService = new UserService();
$userService->register('Вова');
$userService->register('Мария');

$orderService = new OrderService();
$orderService->createOrder(101, 5000.0);
$orderService->createOrder(102, 1200.5);

print_r($userService->getLogs());
print_r($orderService->getLogs());

$userService->clearLogs();

echo "Журнал UserService после очистки: " . count($userService->getLogs()) . " записей" . PHP_EOL;
echo "Журнал OrderService: " . count($orderService->getLogs()) . " записей" . PHP_EOL;

/* Трейт здесь удобнее наследования, 
потому что UserService и OrderService не имеют общего родителя (кроме абстрактного Object). 
 */