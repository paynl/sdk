<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest('GetService', [
        'serviceId' => $config->get('serviceId'),
    ])
    ->run()
;

print_response($response);

/*require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Services\Get as GetServiceRequest;

$authAdapter = getAuthAdapter();

$request = (new GetServiceRequest(Config::getInstance()->get('serviceId')))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;*/
