<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest('GetTerminalTransactionStatus', [
        'terminalTransactionId' => (isset($config) === true ? $config->get('terminalTransactionId') : ''),
    ])
    ->run()
;

print_response($response);
