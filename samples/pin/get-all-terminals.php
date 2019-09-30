<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Pin\GetTerminals as GetTerminalsRequest;

$authAdapter = getAuthAdapter();

$request = new GetTerminalsRequest();

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
