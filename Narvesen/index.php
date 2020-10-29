<?php

declare(strict_types=1);

require_once 'Product.php';
require_once 'StoreStorage.php';
require_once 'ProductFormatter.php';
require_once 'Customer.php';
require_once 'Store.php';
require_once 'CustomerData.php';


$customerList = new CustomerData('./customer-list.txt');
$setId = 3;
$customer = $customerList->loadCustomers()[$setId];
$startingMoney = $customer->getMoney();


$storage = new StoreStorage('./products.txt');
$store = new Store('Narvesen Iļģuciems', $storage->load());


foreach ($store->getAllProducts() as $product) {
    /** @var Product $product */
    echo $product->getId() . ' ';
    echo $product->getName() . ' ';
    echo ProductFormatter::price((int)$product->getPrice()) . ' ';
    echo 'Available amount: ' . ProductFormatter::amount((int)$product->getAmount()) . ' ';
    echo PHP_EOL;
}


echo 'Welcome to ' . $store->getName() . ', ' . $customer->getName() . '!' . PHP_EOL;
echo 'You have ' . CustomerData::price((int)$customer->getMoney()) . PHP_EOL;


$choice = -1;
$stay = 'Y';
$bought = 0;


while ($choice < 0 | $choice > count($store->getAllProducts()) && $stay == 'Y') {

    if ($bought != 0) {
        foreach ($store->getAllProducts() as $product) {
            /** @var Product $product */
            echo $product->getId() . ' ';
            echo $product->getName() . ' ';
            echo ProductFormatter::price((int)$product->getPrice()) . ' ';
            echo 'Available amount: ' . ProductFormatter::amount((int)$product->getAmount()) . ' ';
            echo PHP_EOL;
        }
    }

    $choice = readline('Which product would you like to buy? Enter the index: ');
    $product = $store->getAllProducts()[$choice];

    if ($customer->getMoney() < $product->getPrice()) {
        $customerList->updateData($customer->formatData(), $setId);
        exit('You do not have enough money for that' . PHP_EOL);
    }

    if ($product->getAmount() <= 0 && $choice != -1) {
        echo 'That product is out of stock, try to buy something else' . PHP_EOL;
        $choice = -1;
    } else {

        $product->boughtProduct();

        $customer->removeMoney((int)$product->getPrice());

        $customer->addToBasket($product);

        $customer->addToBill((int)$product->getPrice());

        echo 'The product ' . $product->getName() . ' has been added to your basket. Product price: ' .
            ProductFormatter::price((int)$product->getPrice());
        $bought++;
        echo PHP_EOL;
        if ($customer->getMoney() > 0) {
            $stay = readline('You still have ' .
                CustomerData::price((int)$customer->getMoney()) .
                ' left, want to buy anything else?(Y/N/C))');
            if ($stay == 'C') {
                echo 'Here is you receipt: ' . PHP_EOL;
                foreach ($customer->getCurrentBasket() as $product) {
                    echo $product->getName() . ' ';
                    echo ProductFormatter::price((int)$product->getPrice()) . ' ' . PHP_EOL;
                }
                $stay = readline('You still have ' .
                    CustomerData::price((int)$customer->getMoney()) .
                    ' left, want to buy anything else?(Y/N))');
            }
            $choice = -1;
        } else {
            echo 'You are out of money, thank you, come again' . PHP_EOL;
            $customerList->updateData($customer->formatData(), $setId);
            exit;
        }
    }
}


echo 'Thank you for shopping at ' . $store->getName() . PHP_EOL;
echo 'Here is you receipt: ' . PHP_EOL;
foreach ($customer->getCurrentBasket() as $product) {
    echo $product->getName() . ' ';
    echo ProductFormatter::price((int)$product->getPrice()) . ' ' . PHP_EOL;
}
echo 'Total ' . CustomerData::price((int)$customer->yourBill()) . PHP_EOL;

$customerList->updateData($customer->formatData(), $setId);
