<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\IsPay\Get as IsPayRequest;
use PayNL\Sdk\Request\RequestInterface;

$authAdapter = getAuthAdapter();

$ipAddress = '127.0.0.1';

$request = (new IsPayRequest(IsPayRequest::TYPE_IP, $ipAddress))
    ->setFormat(RequestInterface::FORMAT_JSON)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export(json_decode($response->getBody(), false)->$ipAddress, true)
;
