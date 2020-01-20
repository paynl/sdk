<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'CheckVoucherBalance',
        [
            'cardNumber' => $config->get('voucherNumber')
        ],
        [
            'Voucher' => [
                'pinCode' => '58809',
            ],
        ]
    )
    ->run()
;

print_response($response);
