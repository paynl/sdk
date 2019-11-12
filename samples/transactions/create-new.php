<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config,
    Hydrator,
    Model
};
use PayNL\Sdk\Request\Transactions\Create as CreateTransactionRequest;
use Zend\Hydrator\ClassMethods;

$transaction = (new Hydrator\Transaction)->hydrate([
    'serviceId' => 'SL-3490-4320',
    'amount' => (new ClassMethods())->hydrate([
        'amount'   => 34500,
        'currency' => 'USD'
    ], new Model\Amount()),
    'returnUrl' => 'https://www.pay.nl/return-url',
    'exchangeUrl' => 'https://www.pay.nl/exchange-url',
    'paymentMethod' => [
        'id' => 10,
        'name' => 'Rabobank',
    ],
    'testMode' => 0,
    'transferType' => 'merchant',
    //TODO, delete for goto live - is production merchant ID!!
    'transferValue' => 'M-3421-2120',
    'invoiceDate' => (new DateTime())->sub(new DateInterval('P3D'))->format(DateTime::ATOM),
    'deliveryDate' => (new DateTime())->format(DateTime::ATOM),
    'expiresAt' => (new DateTime())->add(new DateInterval('P7D'))->format(DateTime::ATOM),
    'description' => 'Test description',
    'orderNumber' => 'ORD000000',
    'endUserId' => 0,
    'customer' => (new Hydrator\Customer())->hydrate([
        'initials' => 'B',
        'firstName' => 'Bruce',
        'lastName' => 'Wayne',
        'ip' => '10.0.0.1',
        'birthDate' => (new DateTime())->sub(new DateInterval('P24Y'))->format(DateTime::ATOM),
        'gender' => 'M',
        'phone' => '612121212',
        'email' => 'b.wayne@wayne-enterprises.com',
        'trustLevel' => '-5',
        'bankAccount' => (new Hydrator\BankAccount())->hydrate([
            'iban' => 'NL91ABNA0417164300',
            'bic' => 'INGBNL2A',
            'owner' => 'Bruce Wayne'
        ], new Model\BankAccount()),
        'reference' => '123456789',
        'language' => 'NL',
    ], new Model\Customer()),
    'company' => (new ClassMethods())->hydrate([
        'name' => 'Wayne Enterprises Inc.',
        'coc' => '12345678',
        'vat' => '24456789B01',
        'countryCode' => 'US'
    ], new Model\Company()),
    'address' => (new Hydrator\Address())->hydrate([
        'streetName' => 'Mountain Drive',
        'streetNumber' => '1007',
        'zipCode' => '24857',
        'city' => 'Gotham',
        'regionCode' => 'US-NY',
        'countryCode' => 'US',
        'initials' => 'B',
        'lastName' => 'Wayne'
    ], new Model\Address()),
    'billingAddress' => (new Hydrator\Address())->hydrate([
        'streetName' => 'Mountain Drive',
        'streetNumber' => '1007',
        'zipCode' => '24857',
        'city' => 'Gotham',
        'regionCode' => 'US-NY',
        'countryCode' => 'US',
        'initials' => 'B',
        'lastName' => 'Wayne'
    ], new Model\Address()),
    'products' => [
        (new Hydrator\Product())->hydrate([
            'id' => 'P-1000-00021',
            'description' => 'Tumbler',
            'price' => (new ClassMethods())->hydrate([
                'amount' => '2500000',
                'currency' => 'USD'
            ], new Model\Amount()),
            'quantity' => 1,
            'vat' => 'N'
        ], new Model\Product())
    ],
    'statistics' => (new Hydrator\Statistics())->hydrate([
        'promoterId' => 0,
        'info' => 'This is information',
        'tool' => 'I use this tool',
        'extra1' => '',
        'extra2' => '',
        'extra3' => '',
        'transferData' => [
            'dataaaaa'
        ]
    ], new Model\Statistics()),
], new Model\Transaction());

$authAdapter = getAuthAdapter();

$request = (new CreateTransactionRequest($transaction))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
