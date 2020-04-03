<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest('DeleteDirectdebit', [
        'incassoOrderId' => (isset($config) === true ? $config->get('incassoOrderId') : ''),
    ])
    ->run()
;

print_response($response);
