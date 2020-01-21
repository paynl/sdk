<?php

/*
 * Note: Mandate must have the flag "requeing"
 */

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'CreateRecurringDirectdebit',
        [
            'incassoOrderId' => $config->get('incassoOrderId'),
        ],
        null,
        [
            'Mandate' => [
                'isLastOrder' => true,
                'description' => 'Test recurring',
                'processDate' => \PayNL\Sdk\Common\DateTime::now(),
                'amount' => [
                    'amount' => 200,
                    'currency' => 'EUR',
                ],
                'statistics' => [
                    'info' => 'Test recurring',
                    'tool' => 'Some other tooling',
                    'object' => '',
                    'extra1' => '',
                    'extra2' => '',
                    'extra3' => '',
                ],
            ],
        ]
    )
    ->run()
;

print_response($response);
