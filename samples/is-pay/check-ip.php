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

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
print_response($response);
