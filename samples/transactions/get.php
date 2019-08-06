<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Request\Transactions\GetAll as TransactionsRequest;

// TODO: not paymentMethodId in request but paymentMethod (e.g. IDEAL) -> Fix in REST API
// TODO: Fix API documentation. TransactionId is not required

//$transactionId = 'EX-0181-2295-2190';
//$serviceId = 'SL-3490-4320';
//$paymentMethodId = 10; // iDeal
//$page = 1;

// TODO: filtering

$authAdapter = getAuthAdapter();

$request = new TransactionsRequest();
$request->setFormat(RequestInterface::FORMAT_OBJECTS);

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
