<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Refunds\Get as GetRefundRequest;

$authAdapter = getAuthAdapter();

$request = new GetRefundRequest('RF-7039-3062-3700');

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>';
print_r($response);
exit(0);
