<?php

declare(strict_types=1);

require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Vouchers\Charge as ChargeVoucherRequest;
use PayNL\Sdk\Hydrator\Voucher as VoucherHydrator;
use PayNL\Sdk\Model\Voucher;

$authAdapter = getAuthAdapter();

$request = (new ChargeVoucherRequest(
    Config::getInstance()->get('voucherNumber'),
    (new VoucherHydrator())->hydrate([
        'amount' => [
            'amount' => 1,
            'currency' => 'EUR',
        ],
        'pinCode' => '58809',
    ], new Voucher())
))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
