<?php

declare(strict_types=1);

require_once  __DIR__ . '/../vendor/autoload.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$config = new Config(require 'config.php');

return Application::init($config);
