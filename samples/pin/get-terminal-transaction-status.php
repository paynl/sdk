<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Pin\GetTerminalTransactionStatus as GetTerminalTransactionStatusRequest;

$authAdapter = getAuthAdapter();

$request = (new GetTerminalTransactionStatusRequest('TT-9054-1003-5510'))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
