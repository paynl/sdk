<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Vouchers\Balance as BalanceVoucherRequest;

$authAdapter = getAuthAdapter();

$request = (new BalanceVoucherRequest(Config::getInstance()->get('voucherNumber'), '58809'))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
