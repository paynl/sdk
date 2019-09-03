<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Services\Get as GetServiceRequest;

$authAdapter = getAuthAdapter();

$request = new GetServiceRequest('SL-1066-2020');

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
