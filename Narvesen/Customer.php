<?php

class Customer
{
    private string $name;
    private int $money;
    private array $basket = [];
    private int $bill;
    private int $id;

    public function __construct(int $id, string $name, int $money, int $bill)
    {
        $this->name = $name;
        $this->money = $money;
        $this->bill = $bill;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCustomerId(): string
    {
        return $this->id;
    }

    public function getMoney(): string
    {
        return $this->money;
    }

    public function removeMoney(int $amount): void
    {
        $this->money -= $amount;
    }

    public function addToBasket(object $product): void
    {
        $this->basket[] = $product;
    }

    public function getCurrentBasket(): array
    {
        return $this->basket;
    }


    public function yourBill(): int
    {
        return $this->bill;
    }

    public function addToBill(int $price): void
    {
        $this->bill += $price;
    }

    public function formatData(): string
    {
        return $this->id . ',' .
            $this->name . ',' .
            $this->money . ',' . '0|' . PHP_EOL;
    }
}
