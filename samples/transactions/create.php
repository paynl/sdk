<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Request\Transactions\Create as CreateTransactionRequest;
use PayNL\Sdk\Hydrator;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model;

$transaction = (new Hydrator\Transaction)->hydrate([
    'serviceId' => 'SL-5350-2350',
    'amount' => (new ClassMethods())->hydrate([
        'amount'   => 34500,
        'currency' => 'USD'
    ], new Model\Amount()),
    'returnUrl' => 'http://www.pay.nl',
    'exchange' => (new Hydrator\Exchange())->hydrate([
        'method' => 'GET',
        'type'   => 'json'
    ], new Model\Exchange()),
    'paymentMethodId' => 10,
    'paymentMethodSubId' => 'Rabobank',
    'testMode' => 0,
    'transferType' => 'merchant',
    'transferValue' => 'M-3421-2120', //TODO, delete for goto live - is production merchant ID!!
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
            'vat' => 0
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
    ->setFormat(RequestInterface::FORMAT_OBJECTS)
    ->addHeader('Content-Type', 'application/json')
;

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
