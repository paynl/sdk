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

/*require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Refunds\Get as GetRefundRequest;

$authAdapter = getAuthAdapter();

$request = (new GetRefundRequest('RF-7039-3062-3700'))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;*/
