<?php

class CustomerData
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public static function price(int $money): string
    {
        return '$' . number_format($money / 100, 2);
    }

    public function loadCustomers(): array
    {
        $content = file_get_contents($this->path);

        $rows = array_filter((array)explode('|', $content));
        $customers = [];
        foreach ($rows as $row) {
            $customerData = explode(',', $row);
            var_dump($customerData);
            $customers [] = new Customer(
                (int)$customerData[0],
                trim(($customerData[1])),
                (int)$customerData[2],
                (int)$customerData[3]);
        }
        return $customers;
    }

    public function updateData(string $data, int $person): void
    {
        $file = file($this->path);
        $file[$person] = $data;
        file_put_contents($this->path, $file);
    }
}