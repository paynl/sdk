<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$response = Application::init(Config::getInstance()->toArray())
    ->setRequest(
        'AddTrademark',
        [
            'merchantId' => Config::getInstance()->get('merchantId')
        ],
        [
            'Trademark' => [
                'name' => 'TestTrademark' . random_int(10, 9999),
            ],
        ]
    )
    ->run()
;

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
echo '<pre/>' . PHP_EOL .
    var_export($response->getBody(), true)
;
