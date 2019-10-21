<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

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
    'serviceId' => Config::getInstance()->get('serviceId'),
    'secret'    => '',
    'reference' => 'ABCD0123',
], new QrModel());

/** @var QrModel $qr */
$request = (new EncodeQrRequest($qr))
    ->setDebug((bool)Config::getInstance()->get('debug'));

$response = (new Api($authAdapter))
    ->handleCall($request)
;

/** @var ErrorsModel $errors */
$errors = $response->getBody();

echo '<pre/>' . PHP_EOL .
    'Nr of errors: ' . var_export($errors->count(), true) . PHP_EOL
;
echo 'Errors: ';
foreach ($errors as $key => $value) {
    echo var_export([$key, $value], true) . PHP_EOL;
}
