<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Model\Trademark;
use PayNL\Sdk\Request\Merchants\AddTrademark as AddTrademarkRequest;
use Zend\Hydrator\ClassMethods;

$authAdapter = getAuthAdapter();

$request = (new AddTrademarkRequest(/*'M-6328-7160'*/ 'M-9040-1000', (new ClassMethods())->hydrate([
    'id' => 'TestTrademark',
], new Trademark())))->setDebug(true);

$api = new Api($authAdapter);
$response = $api->handleCall($request);

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
