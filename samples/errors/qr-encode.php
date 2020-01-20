<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'EncodeQr',
        [],
        [
            'Qr' => [
                'serviceId' => 'SL-0000-0000',
                'secret'    => '',
                'reference' => 'ABCD0123',
            ],
        ]
    )
    ->run()
;

/*require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Qr\Encode as EncodeQrRequest;
use PayNL\Sdk\Model\{
    Qr as QrModel,
    Errors as ErrorsModel
};
use PayNL\Sdk\Hydrator\Qr as QrHydrator;

$authAdapter = getAuthAdapter();

$qr = (new QrHydrator())->hydrate([
    'serviceId' => 'SL-0000-0000',
    'secret'    => '',
    'reference' => 'ABCD0123',
], new QrModel());

/** @var QrModel $qr *
$request = (new EncodeQrRequest($qr))
    ->setDebug((bool)Config::getInstance()->get('debug'));

$response = (new Api($authAdapter))
    ->handleCall($request)
;*/

echo '<pre/>' . PHP_EOL;
echo 'Has errors: ' . var_export($response->hasErrors(), true) . PHP_EOL . PHP_EOL;
echo 'Errors: ' . PHP_EOL . $response->getErrors() . PHP_EOL;
