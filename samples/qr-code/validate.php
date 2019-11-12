<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Qr\Validate as ValidateQrRequest;

$authAdapter = getAuthAdapter();

$request = (new ValidateQrRequest('bd4a29ba-1066-2020-4142-434430313233', '0123456789abcdef0123456789abcdef01234567'))
    ->setDebug((bool)Config::getInstance()->get('debug'));

$response = (new Api($authAdapter))
    ->handleCall($request);

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
