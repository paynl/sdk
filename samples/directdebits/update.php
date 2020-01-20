<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'UpdateDirectdebit',
        [
            'incassoOrderId' => $config->get('incassoOrderId'),
        ],
        [
            'Mandate' => [
                'description' => 'Test adjustment',
                'processDate' => \PayNL\Sdk\Common\DateTime::now(),
                'exchangeUrl' => 'https://www.pay.nl/exchange-url2',
                'customer' => [
                    'ip' => '66.249.64.0',
                    'email' => 'somebody@somedomain.com',
                    'bankAccount' => [
                        'owner' => 'PAY.',
                        'bic'   => 'RABONL2U',
                        'iban'  => 'NL35RABO0117713678',
                    ],
                ],
                'amount' => [
                    'amount'   => 300,
                    'currency' => 'EUR',
                ],
                'interval' => [
                    'period'   => 'Week',
                    'quantity' => 2,
                    'value'    => 1,
                ],
                'statistics' => [
                    'info'   => 'test',
                    'tool'   => 'some-tool',
                    'object' => '',
                    'extra1' => '',
                    'extra2' => 'extra2',
                    'extra3' => '',
                ],
            ],
        ]
    )
    ->run()
;

print_response($response);
