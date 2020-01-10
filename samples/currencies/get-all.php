<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$response = Application::init(Config::getInstance()->toArray())
    ->setRequest('GetAllCurrencies')
    ->run()
;

echo '<pre/>' . PHP_EOL .
    var_export($response->getBody(), true)
;
