<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Transactions\Refund as RefundTransactionRequest;
use PayNL\Sdk\Model\{Refund, Amount, Product};
use PayNL\Sdk\Hydrator\{Refund as RefundHydrator, Product as ProductHydrator};
use Zend\Hydrator\ClassMethods;

$authAdapter = getAuthAdapter();

$refund = (new RefundHydrator())->hydrate([
    'amount' => (new ClassMethods())->hydrate([
        'amount' => 10,
        'currency' => 'EUR',
    ], new Amount()),
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

$transactionId = 'EX-6581-2257-2190';
$request = new RefundTransactionRequest($transactionId, $refund);

$response = (new Api($authAdapter))
    ->setDebug(true)
    ->handleCall($request)
;

echo '<pre/>';
print_r($response);
exit(0);
