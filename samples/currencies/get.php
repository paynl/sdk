<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Currencies\Get as CurrenciesRequest;
use PayNL\Sdk\Request\RequestInterface;

$authAdapter = getAuthAdapter();

$request = new CurrenciesRequest('EUR');
$request->setFormat(RequestInterface::FORMAT_OBJECTS);

$response = (new Api($authAdapter))
//    ->setDebug(true)
    ->handleCall($request)
;

echo '<pre/>';
print_r($response);
exit(0);
