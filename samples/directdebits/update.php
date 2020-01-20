<?php

declare(strict_types=1);

require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config,
    DateTime
};
use PayNL\Sdk\Request\Directdebits\Update as UpdateDirectdebitRequest;
use PayNL\Sdk\Hydrator\Mandate as MandateHydrator;
use PayNL\Sdk\Model\Mandate;

$authAdapter = getAuthAdapter();

$mandate = (new MandateHydrator())->hydrate([
    'description' => 'Test adjustment',
    'processDate' => DateTime::now(),
    'exchangeUrl' => 'https://www.pay.nl/exchange-url2',
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
        'amount' => 300,
        'currency' => 'EUR',
    ],
    'interval' => [
        'period' => 'Week',
        'quantity' => 2,
        'value' => 1,
    ],
    'statistics' => [
        'promoterId' => 0,
        'info' => 'test',
        'tool' => 'some-tool',
        'extra1' => '',
        'extra2' => 'extra2',
        'extra3' => '',
        'transferData' => [
            'data'
        ],
    ],
], new Mandate());

$request = (new UpdateDirectdebitRequest(Config::getInstance()->get('incassoOrderId'), $mandate))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
