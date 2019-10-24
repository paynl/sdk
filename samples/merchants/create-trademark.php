<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Model\Trademark;
use PayNL\Sdk\Request\Merchants\AddTrademark as AddTrademarkRequest;
use Zend\Hydrator\ClassMethods;

$authAdapter = getAuthAdapter();

/** @var Trademark $tradeMark */
$tradeMark = (new ClassMethods())->hydrate([
    'name' => 'TestTrademark' . random_int(10, 9999),
], new Trademark());

$request = (new AddTrademarkRequest(Config::getInstance()->get('merchantId'), $tradeMark))
    ->setDebug((bool)Config::getInstance()->get('debug'))
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
