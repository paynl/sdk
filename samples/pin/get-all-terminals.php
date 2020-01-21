<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

use PayNL\Sdk\Model\Terminal;

$response = $app
    ->setRequest('GetTerminals', null, [
        // filters
//        'state' => Terminal::STATE_ACTIVE,
    ])
    ->run()
;

print_response($response);
