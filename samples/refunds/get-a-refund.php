<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest('GetRefund', [
        'refundId' => 'RF-7039-3062-3700',
    ])
    ->run()
;

print_response($response);
