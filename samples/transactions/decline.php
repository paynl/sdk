<?php

declare(strict_types=1);

require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Transactions\Decline as DeclineTransactionRequest;

$authAdapter = getAuthAdapter();

$request = (new DeclineTransactionRequest(Config::getInstance()->get('transactionId')))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
