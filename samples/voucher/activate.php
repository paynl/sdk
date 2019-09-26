<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Voucher\Activate as ActivateVoucherRequest;
use PayNL\Sdk\Hydrator\Voucher as VoucherHydrator;
use PayNL\Sdk\Model\Voucher;

$authAdapter = getAuthAdapter();

$request = (new ActivateVoucherRequest('1234567800273867546', (new VoucherHydrator())->hydrate([
    'amount' => [
        'amount' => 1,
        'currency' => 'EUR',
    ],
    'pinCode' => '58809',
    'posId' => '1541',
], new Voucher())))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
