<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Transactions\Recurring as RecurringTransactionRequest;
use PayNL\Sdk\Hydrator\RecurringTransaction as RecurringTransactionHydrator;
use PayNL\Sdk\Model\RecurringTransaction;

$authAdapter = getAuthAdapter();

$request = (new RecurringTransactionRequest(
    Config::getInstance()->get('transactionId'),
    (new RecurringTransactionHydrator())->hydrate([
        'amount' => [
            'amount' => 10,
            'currency' => 'EUR'
        ],
        'description' => 'Test recurring',
        'extra1' => 'Extra 1',
        'extra2' => 'Extra 2',
        'extra3' => 'Extra 3',
    ], new RecurringTransaction())
))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;