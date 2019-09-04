<?php
declare(strict_types=1);
throw new Exception('TODO: Mike needs to change post data object??');
require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Merchants\Create as CreateMerchantRequest;
use PayNL\Sdk\Hydrator\Merchant as MerchantHydrator;
use PayNL\Sdk\Model\Merchant;

$authAdapter = getAuthAdapter();

$request = new CreateMerchantRequest((new MerchantHydrator())->hydrate([
], new Merchant()));

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);
