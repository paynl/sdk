<?php
declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Merchants\AddBankAccount as AddBankAccountRequest;
use PayNL\Sdk\Hydrator\BankAccount as BankAccountHydrator;
use PayNL\Sdk\Model\BankAccount;

$authAdapter = getAuthAdapter();

$request = new AddBankAccountRequest('M-6328-7160', (new BankAccountHydrator())->hydrate([
    'bank'      => 'INGBNL2A',
    'returnUrl' => 'https://www.my-website.com/return',
], new BankAccount()));

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
