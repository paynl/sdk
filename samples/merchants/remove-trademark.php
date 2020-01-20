<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'DeleteTrademark',
        [
            'merchantId'  => $config->get('merchantId'),
            'trademarkId' => 'TM-4254-8731'
        ]
    )
    ->run()
;

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
print_response($response);
