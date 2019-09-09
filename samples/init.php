<?php
declare(strict_types=1);

use PayNL\Sdk\AuthAdapter\Basic as BasicAuthenticationAdapter;

require_once  __DIR__ . '/../vendor/autoload.php';

function getAuthAdapter(): BasicAuthenticationAdapter
{
    $config = require 'config.php';
    return new BasicAuthenticationAdapter($config['username'], $config['password']);
}
