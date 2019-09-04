<?php
throw new \Exception('TODO: Mike will adjust post request');
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Services\Create as CreateServiceRequest;

$authAdapter = getAuthAdapter();

$request = new CreateServiceRequest();

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);