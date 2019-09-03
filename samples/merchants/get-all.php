<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Merchants\GetAll as GetAllMerchantsRequest;

$authAdapter = getAuthAdapter();

$request = new GetAllMerchantsRequest();

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
