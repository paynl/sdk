<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Directdebits\Delete as RemoveDirectdebitRequest;

$authAdapter = getAuthAdapter();

$request = (new RemoveDirectdebitRequest('IO-8284-8371-9550'))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
