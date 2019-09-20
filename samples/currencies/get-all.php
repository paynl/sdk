<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Currencies\GetAll as GetAllCurrenciesRequest;

$authAdapter = getAuthAdapter();

$request = new GetAllCurrenciesRequest();

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
