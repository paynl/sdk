<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

use PayNL\Sdk\Model\ServicePaymentLink;

$response = $app
    ->setRequest(
        'CreatePaymentLink',
        [
            'serviceId' => 'SL-1066-2020',
        ],
        [
            'ServicePaymentLink' => [
                'securityMode' => ServicePaymentLink::SECURITY_MODE_0,
                'countryCode' => 'NL',
                'language' => 'nl',
                'amount' => [
                    'amount' => 100,
                    'currency' => 'EUR',
                ],
                'amountMin' => [
                    'amount' => 100,
                    'currency' => 'EUR',
                ],
                'statistics' => [
                    'info' => 'Information',
                    'tool' => 'Some tool',
                    'object' => '',
                    'extra1' => '',
                    'extra2' => '',
                    'extra3' => '',
                ],
            ],
        ]
    )
    ->run()
;

print_response($response);

/*require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Services\CreatePaymentLink as CreatePaymentLinkRequest;
use PayNL\Sdk\Hydrator\ServicePaymentLink as ServicePaymentLinkHydrator;
use PayNL\Sdk\Model\ServicePaymentLink;

$authAdapter = getAuthAdapter();

$request = (new CreatePaymentLinkRequest(
    Config::getInstance()->get('serviceId'),
    (new ServicePaymentLinkHydrator())->hydrate([
        'securityMode' => 0,
        'amount' => [
            'amount' => 100,
            'currency' => 'EUR',
        ],
        'amountMin' => [
            'amount' => 100,
            'currency' => 'EUR',
        ],
        'countryCode' => 'NL',
        'language' => 'nl',
        'statistics' => [
            'promoterId' => 0,
            'info' => 'Information',
            'tool' => 'Some tool',
            'extra1' => '',
            'extra2' => '',
            'extra3' => '',
            'transferData' => [
                'data string'
            ],
        ],
    ], new ServicePaymentLink())
))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;*/
