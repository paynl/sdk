<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$response = Application::init(Config::getInstance()->toArray())
    ->setRequest('GetTerminalTransactionStatus')
    ->run()
;

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
echo '<pre/>' . PHP_EOL .
    var_export($response->getBody(), true)
;

//use PayNL\Sdk\{
//    Api,
//    Config
//};
//use PayNL\Sdk\Request\Pin\GetTerminalTransactionStatus as GetTerminalTransactionStatusRequest;
//
//$authAdapter = getAuthAdapter();
//
//$request = (new GetTerminalTransactionStatusRequest(Config::getInstance()->get('terminalTransactionId')))
//    ->setDebug((bool)Config::getInstance()->get('debug'))
//;
//
//$response = (new Api($authAdapter))
//    ->handleCall($request)
//;
//
//echo '<pre/>' . PHP_EOL .
//    var_export($response, true)
//;
