<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Request\Transactions\GetReceipt as GetTransactionReceiptRequest;

$authAdapter = getAuthAdapter();
// TODO fixen, was niet aanwezig, @Mike fixed een voorbeeld
$request = (new GetTransactionReceiptRequest('EX-1736-0219-9960'))
    ->setFormat(RequestInterface::FORMAT_OBJECTS)
;

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
