<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Paynl\SDK\Gateway;

$gateway = new Gateway([
    'tokenCode' => 'AT-1234-5678',
    'token' => '1234567890asbdfkjadfjkjb',
    'baseUrl' => 'https://url-to-new-rest.api/v1/'
]);