<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Merchants\DeleteTrademark as RemoveTrademarkRequest;

$authAdapter = getAuthAdapter();

$request = (new RemoveTrademarkRequest(/*'M-6328-7160'*/ 'M-9040-1000', 'TM-4324-3681'))
    ->setDebug(true)
;

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;

