<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'MakeTransactionRecurring',
        [
            'transactionId' => $config->get('transactionId'),
        ],
        [
            'RecurringTransaction' => [
                'amount' => [
                    'amount' => 10,
                    'currency' => 'EUR'
                ],
                'description' => 'Test recurring',
                'extra1' => 'Extra 1',
                'extra2' => 'Extra 2',
                'extra3' => 'Extra 3',
            ],
        ]
    )
    ->run()
;

print_response($response);

/*require_once __DIR__ . '/../init_application.php';

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
;*/
