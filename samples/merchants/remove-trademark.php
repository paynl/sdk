<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Merchants\DeleteTrademark as RemoveTrademarkRequest;

$authAdapter = getAuthAdapter();

$request = (new RemoveTrademarkRequest(Config::getInstance()->get('merchantId'), 'TM-4324-3681'))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
