<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'MakeTransactionRecurring',
        [
            'transactionId' => (isset($config) ? $config->get('transactionId') : ''),
        ],
        null,
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
