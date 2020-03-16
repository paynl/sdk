<?php

declare(strict_types=1);

return [
    'config_paths' => [
        __DIR__ . DIRECTORY_SEPARATOR . '_support' . DIRECTORY_SEPARATOR . 'TestAsset' . DIRECTORY_SEPARATOR . 'ConfigProvider.php',
    ],
    'api' => [
        'url'  => 'https://rest.idefix.mike.dev.pay.nl/',
    ],
    'authentication' => [
        'username' => 'token',
        'password' => '68babb1a525f6116b387231af9d2e4413a6c8f61',
    ],
//    'request' => [
//        'format' => 'objects' // choose one of the formats declared in \PayNL\Sdk\Request\RequestInterface
//    ],
//    'response' => [
//        'format' => 'objects' // choose one of the formats declared in \PayNL\Sdk\Response\ResponseInterface
//    ],

    'debug'         => false,

    // sample data
    'incassoOrderId'        => 'IO-6880-7472-0100',
    'merchantId'            => 'M-9040-1000',
    'refundId'              => 'RF-7039-3062-3700',
    'serviceId'             => 'SL-3167-1271',
    'terminalId'            => 'TH-3640-7060',
    'terminalTransactionId' => 'TT-9288-4049-2210',
    'transactionId'         => 'EX-3338-5372-0550',
    'cardNumber'            => '1234567800273867546', //voucher
];
