<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Transactions\Recurring as RecurringTransactionRequest;
use PayNL\Sdk\Hydrator\RecurringTransaction as RecurringTransactionHydrator;
use PayNL\Sdk\Model\RecurringTransaction;

$authAdapter = getAuthAdapter();

$transactionId = 'EX-6581-2257-2190';
$request = new RecurringTransactionRequest($transactionId, (new RecurringTransactionHydrator())->hydrate([
    'amount' => [
        'amount' => 10,
        'currency' => 'EUR'
    ],
    'description' => 'Test recurring',
    'extra1' => 'Extra 1',
    'extra2' => 'Extra 2',
    'extra3' => 'Extra 3',
], new RecurringTransaction()));

$response = (new Api($authAdapter))
    ->setDebug(true)
    ->handleCall($request)
;

echo '<pre/>';
print_r($response);
exit(0);
