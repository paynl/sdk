<?php

declare(strict_types=1);

$autoloader = require __DIR__ . '/composer_autoloader.php';

if (false === $autoloader()) {
    die(
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$config = (new Config(require __DIR__ . '/../config/config.global.php'))
    ->merge(new Config(require __DIR__ . '/../config/config.local.php'))
;

return Application::init($config);
