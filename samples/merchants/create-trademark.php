<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'AddTrademark',
        [
            'merchantId' => (isset($config) === true ? $config->get('merchantId') : ''),
        ],
        null,
        [
            'Trademark' => [
                'name' => 'TestTrademark' . random_int(10, 9999),
            ],
        ]
    )
    ->run()
;

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
print_response($response);
