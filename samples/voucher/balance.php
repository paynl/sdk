<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'CheckVoucherBalance',
        [
            'cardNumber' => (isset($config) === true ? $config->get('cardNumber') : ''),
        ],
        null,
        [
            'Voucher' => [
                'pinCode' => '58809',
            ],
        ]
    )
    ->run()
;

print_response($response);
