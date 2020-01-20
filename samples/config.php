<?php

declare(strict_types=1);

return [
// TODO: put to env file?
    'api' => [
        'url'  => 'https://rest.idefix.mike.dev.pay.nl/',
//        'version'  => 1,
    ],
    'authentication' => [
//        'type'     => 'Basic',
        'username' => 'token',
        'password' => '68babb1a525f6116b387231af9d2e4413a6c8f61',
    ],
//    'request' => [
//        'format' => 'objects'
//    ],
//    'response' => [
//        'format' => 'objects'
//    ],

    'debug'         => true,

    // sample data
    'incassoOrderId'        => 'IO-8284-8371-9550',
//    'merchantId'            => 'M-6328-7160',
    'merchantId'            => 'M-9040-1000',
    'refundId'              => 'RF-7039-3062-3700',
    'serviceId'             => 'SL-3167-1271',
    'terminalId'            => 'TH-3640-7060',
    'terminalTransactionId' => 'TT-9288-4049-2210',
    'transactionId'         => 'EX-3338-5372-0550',
    'voucherNumber'         => '1234567800273867546',
];
