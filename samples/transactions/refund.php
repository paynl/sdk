<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Transactions\Refund as RefundTransactionRequest;
use PayNL\Sdk\Model\{
    Refund,
    Amount,
    Product
};
use PayNL\Sdk\Hydrator\{
    Refund as RefundHydrator,
    Product as ProductHydrator
};
use Zend\Hydrator\ClassMethods;

$authAdapter = getAuthAdapter();

$refund = (new RefundHydrator())->hydrate([
    'amount' => (new ClassMethods())->hydrate([
        'amount' => 100,
        'currency' => 'EUR',
    ], new Amount()),
    'bankAccount' => [
        'iban'  => 'NL91ABNA0417164300',
        'bic'   => 'INGBNL2A',
        'owner' => 'Bruce Wayne'
    ],
    'products' => [
        (new ProductHydrator())->hydrate([
            'id' => 'P-0000-0000',
            'description' => 'Test product',
            'quantity' => 1,
        ], new Product()),
        [
            'id' => 'P-0000-0001',
            'description' => 'product as array',
            'quantity' => 1,
        ]
    ],
    'reason' => 'Product was broken',
    'processDate' => (new DateTime())->sub(new DateInterval('P2D'))->format(DateTime::ATOM),
], new Refund());

$request = (new RefundTransactionRequest(Config::getInstance()->get('transactionId'), $refund))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
