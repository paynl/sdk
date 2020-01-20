<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'CreateDirectdebit',
        [],
        [
            'Mandate' => [
                'serviceId' => 'SL-3490-4320',
                'description' => 'Test directdebit',
                'processDate' => PayNL\Sdk\Common\DateTime::now(),
                'exchangeUrl' => 'https://www.pay.nl/exchange-url',
                'customer' => [
                    'ip' => '66.249.64.0',
                    'email' => 'somebody@somedomain.com',
                    'bankAccount' => [
                        'owner' => 'PAY.',
                        'bic' => 'RABONL2U',
                        'iban' => 'NL35RABO0117713678',
                    ],
                ],
                'amount' => [
                    'amount' => 2994,
                    'currency' => 'EUR',
                ],
                'interval' => [
                    'period' => 'Month',
                    'quantity' => 1,
                    'value' => 1,
                ],
                'statistics' => [
                    'promoterId' => 0,
                    'info' => 'test',
                    'tool' => 'some-tool',
                    'extra1' => '',
                    'extra2' => '',
                    'extra3' => '',
                    'transferData' => [
                        'data'
                    ],
                ],
            ],
        ]
    )
    ->run()
;

print_response($response);
