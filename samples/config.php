<?php

declare(strict_types=1);

use PayNL\Sdk\Config;

return [
    Config::KEY_API_URL  => 'https://rest.idefix-rest-api-mike.ian.dev.pay.nl/v1/',
//    Config::KEY_API_URL  => 'https://rest.idefix.mike.dev.pay.nl/v1/',
    Config::KEY_USERNAME => 'token',
    Config::KEY_PASSWORD => '68babb1a525f6116b387231af9d2e4413a6c8f61',

    'debug'         => true,

    // sample data
    'incassoOrderId'        => 'IO-8284-8371-9550',
//    'merchantId'            => 'M-6328-7160',
    'merchantId'            => 'M-9040-1000',
    'refundId'              => 'RF-7039-3062-3700',
    'serviceId'             => 'SL-1066-2020',
    'terminalId'            => 'TH-3640-7060',
    'terminalTransactionId' => 'TT-9054-1003-5510',
    'transactionId'         => 'EX-7436-1212-5160',
    'voucherNumber'         => '1234567800273867546',
];
