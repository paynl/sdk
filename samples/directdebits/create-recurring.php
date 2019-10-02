<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config,
    DateTime
};
use PayNL\Sdk\Model\Mandate;
use PayNL\Sdk\Request\Directdebits\CreateRecurring as CreateRecurringDirectdebitRequest;
use PayNL\Sdk\Hydrator\Mandate as MandateHydrator;

$authAdapter = getAuthAdapter();

$request = (new CreateRecurringDirectdebitRequest(
    Config::getInstance()->get('incassoOrderId'),
    (new MandateHydrator())->hydrate([
        'id' => '',
        'type' => '',
        'isLastOrder' => true,
        'description' => 'Test recurring',
        'processDate' => DateTime::now(),
        'amount' => [
            'amount' => 200,
            'currency' => 'EUR',
        ],
        'statistics' => [
            'promoterId' => 0,
            'info' => 'Test recurring',
            'tool' => 'Some other tooling',
            'extra1' => '',
            'extra2' => '',
            'extra3' => '',
            'transferData' => [
                'Recurring transfer data',
            ],
        ],
    ], new Mandate())
))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
