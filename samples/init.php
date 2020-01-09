<?php

declare(strict_types=1);

use PayNL\Sdk\Config\Config;

require_once  __DIR__ . '/../vendor/autoload.php';

// init config
$config = Config::getInstance();
$config->load(require 'config.php');
