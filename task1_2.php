<?php
declare(strict_types=1);

abstract class Employee
{
    protected string $name;
    protected float $baseSalary;

    public function __construct(string $name, float $baseSalary)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
    }

    abstract public function calculateSalary(): float;

    public function getName(): string
    {
        return $this->name;
    }
}

class Manager extends Employee
{
    public function calculateSalary(): float
    {
        return $this->baseSalary * 1.2; 
    }
}

class Developer extends Employee
{
    private int $overtimeHours = 0;

    public function setOvertimeHours(int $hours): void
    {
        $this->overtimeHours = $hours;
    }

    public function calculateSalary(): float
    {
        return $this->baseSalary + ($this->overtimeHours * 500);
    }
}

class Intern extends Employee
{
    public function calculateSalary(): float
    {
        return $this->baseSalary * 0.5; 
    }
}

function printPayroll(array $employees): void
{
    $totalFund = 0.0;
    
    foreach ($employees as $employee) {
        $salary = $employee->calculateSalary();
        $totalFund += $salary;
        echo "{$employee->getName()} — " . number_format($salary, 2) . " руб." . PHP_EOL;
    }

    echo "Общий фонд оплаты труда: " . number_format($totalFund, 2) . " руб." . PHP_EOL;
}

$manager = new Manager('Анна', 50000);
$developer = new Developer('Иван', 40000);
$developer->setOvertimeHours(10);
$intern = new Intern('Олег', 20000);

printPayroll([$manager, $developer, $intern]);

/* нельзя создать объект класса  напрямую, потому что класс  абстрактным. 
Абстрактные классы только для наследования, они задают общий шаблон */