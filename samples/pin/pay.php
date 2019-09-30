<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Pin\PayTransaction as PayTransactionRequest;
use PayNL\Sdk\Hydrator\Terminal as TerminalHydrator;
use PayNL\Sdk\Model\Terminal;

$authAdapter = getAuthAdapter();

$request = (new PayTransactionRequest('EX-6581-2257-2190', (new TerminalHydrator())->hydrate([
    'id' => 'TH-3640-7060',
], new Terminal())))
    ->setDebug(true)
;

$response = (new Api($authAdapter))
    ->handleCall($request)
;

echo '<pre/>' . PHP_EOL .
    var_export($response, true)
;
