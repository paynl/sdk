<?php
include "../gateway.php";

use Paynl\SDK\Model\Transaction;
use Paynl\SDK\Model\Address;

$address = new Address();
$address->initials = 'AM';
$address->lastName = 'Pieters';
$address->streetName = "Kopersteden";
$address->streetNumber = "10";
$address->streetNumberExtension = "Z";
$address->zipCode = "7547 TK";
$address->city = "Enschede";
$address->countryCode = "US";
$address->regionCode = "US-AL";


$transaction = Transaction::fromArray([
    'description' => 'Test transactie',
    'amount' => ['amount' => 1000],
    'serviceId' => 'SL-4241-3001',
    'exchange' => ['url' => 'https://my-exchange.url'],
    'returnUrl' => 'https://andypieters.nl',
    'products' => [
        ['id' => '1', 'description' => 'Koffie', 'price' => 100, 'quantity' => 5],
        ['id' => '2', 'description' => 'Thee', 'price' => 50, 'quantity' => 5],
        ['id' => '3', 'description' => 'Suiker', 'price' => ['amount' => 10, 'currency' => 'USD'], 'quantity' => 25]
    ],
    'address' => $address,
    'billingAddress' => $address
]);
$transaction->testMode = true;
$transaction->invoiceDate = new DateTime('now');
$transaction->deliveryDate = new DateTime('+3 days');

$transaction = $gateway->transactions()->post($transaction);

echo $transaction->id . PHP_EOL;
echo $transaction->issuerUrl . PHP_EOL;

echo PHP_EOL;

echo $transaction->asJson();