<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Currencies\GetAll as GetAllCurrenciesRequest;
use PayNL\Sdk\Request\RequestInterface;

$authAdapter = getAuthAdapter();

$request = new GetAllCurrenciesRequest();
$request->setFormat(RequestInterface::FORMAT_OBJECTS);

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>';
print_r($response);
exit(0);
