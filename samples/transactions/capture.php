<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest('CaptureTransaction', [
        'transactionId' => $config->get('transactionId'),
    ])
    ->run()
;

print_response($response);
