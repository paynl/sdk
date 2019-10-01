<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Transactions\Cancel as VoidTransactionRequest;

$authAdapter = getAuthAdapter();

$request = (new VoidTransactionRequest(Config::getInstance()->get('transactionId')))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
