<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Request\Transactions\GetReceipt as GetTransactionReceiptRequest;

$authAdapter = getAuthAdapter();
$request = (new GetTransactionReceiptRequest('EX-7436-1212-5160'))
    ->setFormat(RequestInterface::FORMAT_OBJECTS)
;

$response = (new Api($authAdapter))
    ->setDebug(true)
    ->handleCall($request)
;

echo '<pre/>';
print_r($response);
exit(0);
