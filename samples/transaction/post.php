<?php
include "../config.php";


$transaction = \Paynl\SDK\Model\Transaction::fromArray([
    'description' => 'Test transactie',
    'price' => ['amount' => 1000],
    'serviceId' => 'SL-4241-3001',
    'exchange' => ['url' => 'https://my-exchange.url'],
    'returnUrl' => 'https://andypieters.nl',
    'products' => [
        ['id' => '1', 'description' => 'Koffie', 'price' => ['amount' => 100], 'quantity' => 5],
        ['id' => '2', 'description' => 'Thee', 'price' => ['amount' => 50], 'quantity' => 5],
        ['id' => '3', 'description' => 'Suiker', 'price' => ['amount' => 10], 'quantity' => 25],
    ],
    'address' => [],
    'billingAddress' => []
]);

$transaction = $gateway->transaction()->post($transaction);

echo $transaction->id;
