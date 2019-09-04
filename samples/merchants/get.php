<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Merchants\Get as GetMerchantRequest;

$authAdapter = getAuthAdapter();

$request = new GetMerchantRequest('M-6328-7160');

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);