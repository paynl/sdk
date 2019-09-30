<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Transactions\Get as GetTransactionRequest;

$authAdapter = getAuthAdapter();

$request = new GetTransactionRequest('EX-7436-1212-5160');

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
