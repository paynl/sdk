<?php

declare(strict_types=1);

return [
    'config_paths' => [
        // add paths to custom ConfigProvider files (modules)
    ],

    'request' => [
        'format' => 'objects' // choose one of the formats declared in \PayNL\Sdk\Request\RequestInterface
    ],
    'response' => [
        'format' => 'objects' // choose one of the formats declared in \PayNL\Sdk\Response\ResponseInterface
    ],

    'debug'         => false,
];
