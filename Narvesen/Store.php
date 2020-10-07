<?php


class Store
{

    private string $name;

    private array $products = [];

    public function __construct(string $name, array $products = [])
    {
        $this->name = $name;

        foreach ($products as $product) {
            $this->add($product);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function add(object $product): void
    {
        $this->products[] = $product;
    }

    public function getAllProducts(): array
    {
        return $this->products;
    }

    public function buyProduct($index): string
    {
        return $this->products[$index];
    }

    public function showAllProducts(): void
    {
        foreach ($this->getAllProducts() as $product) {
            /** @var Product $product */
            echo $product->getId() . ' ';
            echo $product->getName() . ' ';
            echo ProductFormatter::price((int)$product->getPrice()) . ' ';
            echo 'Available amount: ' . ProductFormatter::amount((int)$product->getAmount()) . ' ';
            echo PHP_EOL;
        }
    }
}

