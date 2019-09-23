<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    DateTime
};
use PayNL\Sdk\Request\Directdebits\Create as CreateDirectdebitRequest;
use PayNL\Sdk\Hydrator\Mandate as MandateHydrator;
use PayNL\Sdk\Model\Mandate;

$authAdapter = getAuthAdapter();

$mandate = (new MandateHydrator())->hydrate([
    'serviceId' => 'SL-5796-8370',
    'description' => 'Test directdebit',
    'processDate' => DateTime::now(),
    'exchangeUrl' => 'https://www.pay.nl/exchange-url',
    'customer' => [
        'ip' => '66.249.64.0',
        'email' => 'somebody@somedomain.com',
        'bankAccount' => [
            'owner' => 'PAY.',
            'bic' => 'RABONL2U',
            'iban' => 'NL35RABO0117713678',
        ],
    ],
    'amount' => [
        'amount' => 2994,
        'currency' => 'EUR',
    ],
    'interval' => [
        'period' => 'Month',
        'quantity' => 1,
        'value' => 1,
    ],
    'statistics' => [
        'promoterId' => 0,
        'info' => 'test',
        'tool' => 'some-tool',
        'extra1' => '',
        'extra2' => '',
        'extra3' => '',
        'transferData' => [
            'data'
        ],
    ],
], new Mandate());

$request = (new CreateDirectdebitRequest($mandate))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
