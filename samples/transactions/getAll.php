<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Request\Transactions\GetAll as TransactionsRequest;
use PayNL\Sdk\Filter;

// TODO: not paymentMethodId in request but paymentMethod (e.g. IDEAL) -> Fix in REST API
// TODO: Fix API documentation. TransactionId is not required

//$serviceId = 'SL-3490-4320';
$serviceId = 'SL-5350-2350';
$paymentMethodId = 10; // iDeal
$page = 2;

$authAdapter = getAuthAdapter();

$request = new TransactionsRequest();
$request->setFormat(RequestInterface::FORMAT_OBJECTS)
//    ->addFilter(new Filter\TransactionId($transactionId))
    // status filter
//    ->addFilter(new Filter\ServiceId($serviceId))
//    ->addFilter(new Filter\PaymentMethodId($paymentMethodId))
//    ->addFilter(new Filter\Page($page))
;

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
