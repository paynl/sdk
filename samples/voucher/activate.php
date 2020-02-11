<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'ActivateVoucher',
        [
            'cardNumber' => (isset($config) ? $config->get('cardNumber') : ''),
        ],
        null,
        [
            'Voucher' => [
                'amount' => [
                    'amount' => 1,
                    'currency' => 'EUR',
                ],
                'pinCode' => '58809',
                'posId' => '1541',
            ],
        ]
    )
    ->run()
;

print_response($response);
