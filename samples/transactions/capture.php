<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Transactions\Capture as CaptureTransactionRequest;

$authAdapter = getAuthAdapter();

$transactionId = 'EX-6581-2257-2190';
$request = new CaptureTransactionRequest($transactionId);

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print 'transaction ID: ' . $transactionId . PHP_EOL . PHP_EOL;
print_r($response);
exit(0);
