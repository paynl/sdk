<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Pin\ConfirmTerminalTransaction as ConfirmTerminalTransactionRequest;
use PayNL\Sdk\Hydrator\TerminalTransaction as TerminalTransactionHydrator;
use PayNL\Sdk\Model\TerminalTransaction;

$authAdapter = getAuthAdapter();

$request = (new ConfirmTerminalTransactionRequest('TT-9054-1003-5510', (new TerminalTransactionHydrator())->hydrate([
    'email'    => 'o.prime@cybertron.net',
    'language' => 'nl',
], new TerminalTransaction())))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
