<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Voucher\Balance as BalanceVoucherRequest;

$authAdapter = getAuthAdapter();

$request = (new BalanceVoucherRequest('1234567800273867546'))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
