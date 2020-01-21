<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'GetPaymentMethods',
        [
            'serviceId' => $config->get('serviceId'),
        ],
        // filters
        [
//            'country' => [
//                'NL',
//                'BE',
//            ],
        ]
    )
    ->run()
;

print_response($response);
