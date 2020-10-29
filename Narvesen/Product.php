<?php


class Product
{
    private int $price;
    private string $name;
    private int $amount;
    private int $id;

    public function __construct(int $id, string $name, int $price, int $amount)
    {
        $this->price = $price;
        $this->name = $name;
        $this->amount = $amount;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function boughtProduct(): int
    {
        return $this->amount -= 1;
    }
}
