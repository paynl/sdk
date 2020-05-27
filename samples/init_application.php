<?php

declare(strict_types=1);

$vendorDir = __DIR__ . '/../vendor';
if (false === is_dir($vendorDir)) {
    $vendorDir = __DIR__ . '/../../../../vendor';
}

require_once  $vendorDir . '/autoload.php';

use PayNL\Sdk\{
    Application\Application,
    Config\Config
};

$config = new Config(require 'config.php');

return Application::init($config);
