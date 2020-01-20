<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest('GetTerminals')
    ->run()
;

print_response($response);

/*use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$response = Application::init(Config::getInstance()->toArray())
    ->setRequest('GetTerminals')
    ->run()
;

// NOTE: only approved trademarks are given to the response merchant object, the new trademark isn't instantly approved
echo '<pre/>' . PHP_EOL .
    var_export($response->getBody(), true)
;*/
