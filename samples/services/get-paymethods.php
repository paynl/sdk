<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Services\GetPaymentMethods as GetServicePaymentMethodsRequest;

$authAdapter = getAuthAdapter();

$request = new GetServicePaymentMethodsRequest('SL-1066-2020');

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
