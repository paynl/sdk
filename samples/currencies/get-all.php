<?php

declare(strict_types=1);

require_once __DIR__ . '/../init.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$app = Application::init(Config::getInstance()->toArray());
$app->setRequest('GetAllCurrencies');

$response = $app->run();

echo '<pre/>' . PHP_EOL .
    var_export($response->getBody(), true)
;
