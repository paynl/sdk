<?php

define('PROJECT_ROOT', '');

require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once PROJECT_ROOT . '/config.php';

\Paynl\Config::setApiToken($_REQUEST['password'] ?? '');
\Paynl\Config::setServiceId($_REQUEST['username'] ?? '');

try {
    $result = \Paynl\Instore::getAllTerminals();

    var_dump($result->getData());
} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}
