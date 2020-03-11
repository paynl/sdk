<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'GetDirectdebit',
        [
            'incassoOrderId' => (isset($config) ? $config->get('incassoOrderId') : ''),
        ]
    )
    ->run()
;

print_response($response);