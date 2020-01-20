<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

use PayNL\Sdk\Model\ServicePaymentLink;

$response = $app
    ->setRequest(
        'CreatePaymentLink',
        [
            'serviceId' => 'SL-1066-2020',
        ],
        [
            'ServicePaymentLink' => [
                'securityMode' => ServicePaymentLink::SECURITY_MODE_0,
                'countryCode' => 'NL',
                'language' => 'nl',
                'amount' => [
                    'amount' => 100,
                    'currency' => 'EUR',
                ],
                'amountMin' => [
                    'amount' => 100,
                    'currency' => 'EUR',
                ],
                'statistics' => [
                    'info' => 'Information',
                    'tool' => 'Some tool',
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
