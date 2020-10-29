<?php

class StoreStorage
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function load(): array
    {
        $content = file_get_contents($this->path);

        $rows = array_filter((array)explode('|', $content));
        $products = [];

        foreach ($rows as $row) {
            $productData = explode(',', $row);
            $products [] = new Product(
                (int)$productData[0],
                trim(($productData[1])),
                (int)$productData[2],
                (int)$productData[3]);
        }
        return $products;
    }
}
