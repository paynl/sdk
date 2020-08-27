<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'GetMerchant',
        [
            'merchantId' => (isset($config) === true ? $config->get('merchantId') : ''),
        ]
    )
    ->run()
;

print_response($response);
