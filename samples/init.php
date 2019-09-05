<?php
declare(strict_types=1);

use PayNL\Sdk\Config;
use PayNL\Sdk\AuthAdapter\Basic as BasicAuthenticationAdapter;

require_once  __DIR__ . '/../vendor/autoload.php';

// init config
$config = Config::getInstance();
$config->load(require 'config.php');

if (false === function_exists('getAuthAdapter')) {
    function getAuthAdapter(): BasicAuthenticationAdapter
    {
        $config = Config::getInstance();
        return new BasicAuthenticationAdapter($config->getUserName(), $config->getPassword());
    }
}
