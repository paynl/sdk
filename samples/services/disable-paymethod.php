<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Services\DisablePaymentMethod as DisablePaymentMethodRequest;

$authAdapter = getAuthAdapter();

$request = new DisablePaymentMethodRequest('SL-1066-2020', 739);

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>';
print_r($response);
exit(0);
