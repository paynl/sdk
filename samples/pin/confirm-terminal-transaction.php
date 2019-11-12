<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Pin\ConfirmTerminalTransaction as ConfirmTerminalTransactionRequest;

$authAdapter = getAuthAdapter();

$request = (new ConfirmTerminalTransactionRequest(
    Config::getInstance()->get('terminalTransactionId'),
    'o.prime@cybertron.net',
    'nl'
))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
