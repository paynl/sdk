<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Pin\PayTransaction as PayTransactionRequest;
use PayNL\Sdk\Hydrator\Terminal as TerminalHydrator;
use PayNL\Sdk\Model\Terminal;

$authAdapter = getAuthAdapter();

$request = (new PayTransactionRequest(Config::getInstance()->get('transactionId'), (new TerminalHydrator())->hydrate([
    'id' => Config::getInstance()->get('terminalId'),
], new Terminal())))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
