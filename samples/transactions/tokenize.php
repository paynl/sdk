<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'TokenizeTransaction',
        [
            'transactionId' => $config->get('transactionId'),
        ],
        [
            'CompanyCard' => [
                // Choose one of the following keys to fill the correct data:
                'id'    => 'VY-6036-0071-6000',
//                'token' => '9572a3ac8a41b05646f0acaf613735f2ef6630dbb1fb94b4a4119af2d67ca65b'
            ],
        ]
    )
    ->run()
;

print_response($response);
