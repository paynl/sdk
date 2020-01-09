<?php

declare(strict_types=1);

use PayNL\Sdk\Config;
use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Response\ResponseInterface;

return [

    'api' => [
        'url'  => 'https://rest.idefix.mike.dev.pay.nl/',
        'version'  => 1,
    ],
    'authentication' => [
        'type'     => 'Basic',
        'username' => 'token',
        'password' => '68babb1a525f6116b387231af9d2e4413a6c8f61',
    ],
    'request' => [
        'format' => RequestInterface::FORMAT_OBJECTS
    ],
    'response' => [
        'format' => ResponseInterface::FORMAT_OBJECTS
    ],

    'debug'         => true,

    // sample data
    'incassoOrderId'        => 'IO-8284-8371-9550',
//    'merchantId'            => 'M-6328-7160',
    'merchantId'            => 'M-9040-1000',
    'refundId'              => 'RF-7039-3062-3700',
    'serviceId'             => 'SL-3167-1271',
    'terminalId'            => 'TH-3640-7060',
    'terminalTransactionId' => 'TT-9054-1003-5510',
    'transactionId'         => 'EX-7436-1212-5160',
    'voucherNumber'         => '1234567800273867546',
];
