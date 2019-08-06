<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Request\Transactions\Get as GetTransactionRequest;

$authAdapter = getAuthAdapter();

$request = (new GetTransactionRequest('EX-9681-2215-2190'))
    ->setFormat(RequestInterface::FORMAT_OBJECTS)
;

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
