<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'PayTransaction',
        [
            'transactionId' => $config->get('transactionId'),
        ],
        null,
        [
            'Terminal' => [
                'id' => $config->get('terminalId'),
            ],
        ]
    )
    ->run()
;

print_response($response);
