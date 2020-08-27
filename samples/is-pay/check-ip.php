<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'IsPay',
        [
            'ip' => '127.0.0.1',
        ]
    )
    ->run()
;

print_response($response);
